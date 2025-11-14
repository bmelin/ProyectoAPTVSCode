<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteHistorial;
use App\Models\Paciente;
use App\Models\RespuestaBinaria;
use App\Models\OpcionAlcohol;
use App\Models\OpcionEjercicio;
use App\Models\OpcionMenstruacion;
use App\Models\OpcionPrimerHijo;
use Carbon\Carbon;

class PacienteHistorialController extends Controller
{
    /**
     * Mostrar formulario de creación de historial médico
     */
    public function crear(Request $request, $id_paciente)
    {
        $paciente = Paciente::findOrFail($id_paciente);

        // Verificar si ya tiene historiales
        $tieneHistorial = $paciente->historiales()->exists();
        $ultimoHistorial = null;
        $edad = $request->edad ?? null;
        $menstruacion = null;
        $primerHijo = null;
        $antecedentes = [
            'id_familiar_primer_grado' => null,
            'id_familiar_segundo_grado' => null,
            'id_diagnostico_previo' => null,
        ];

        if ($tieneHistorial) {
            $ultimoHistorial = $paciente->historiales()
                ->latest('fecha_registro')
                ->with(['antecedentes', 'familiares', 'reproductivos'])
                ->first();

            if ($ultimoHistorial->edad && $ultimoHistorial->fecha_registro) {
                $fechaUltimo = Carbon::parse($ultimoHistorial->fecha_registro);
                $edad = $ultimoHistorial->edad + $fechaUltimo->diffInYears(now());
            }

            $menstruacion = $ultimoHistorial->reproductivos->id_menstruacion ?? null;
            $primerHijo = $ultimoHistorial->reproductivos->id_primer_hijo ?? null;

            $antecedentes['id_familiar_primer_grado'] = $ultimoHistorial->familiares->id_familiar_primer_grado ?? null;
            $antecedentes['id_familiar_segundo_grado'] = $ultimoHistorial->familiares->id_familiar_segundo_grado ?? null;
            $antecedentes['id_diagnostico_previo'] = $ultimoHistorial->antecedentes->id_diagnostico_previo ?? null;
        }

        // Opciones dinámicas desde tablas normalizadas
        $respuestas = RespuestaBinaria::all();
        $opcionesEjercicio = OpcionEjercicio::all();
        $opcionesAlcohol = OpcionAlcohol::all();
        $opcionesMenstruacion = OpcionMenstruacion::all();
        $opcionesPrimerHijo = OpcionPrimerHijo::all();

        // --------------------------
        // REGLAS DE FILTRADO
        // --------------------------
        $ID_NUNCA     = 'nunca';
        $ID_MENOR30   = 'menor_a_30';
        $ID_MAYOR30   = 'mayor_a_30';

        // ❗ Regla 1: Si edad < 30 → no permitir “Mayor de 30”
        if ($edad !== null && $edad < 30) {
            $opcionesPrimerHijo = $opcionesPrimerHijo->filter(function($op) use ($ID_MAYOR30) {
                return $op->id_primer_hijo !== $ID_MAYOR30;
            });
        }

        // ❗ Regla 2: Si en el último historial marcó “nunca” + tiene >30 años → no permitir “Menor de 30”
        if ($primerHijo === $ID_NUNCA && $edad > 30) {
            $opcionesPrimerHijo = $opcionesPrimerHijo->filter(function($op) use ($ID_MENOR30) {
                return $op->id_primer_hijo !== $ID_MENOR30;
            });
        }

        return view('medico.registrarhistorial', compact(
            'id_paciente',
            'edad',
            'tieneHistorial',
            'menstruacion',
            'primerHijo',
            'antecedentes',
            'opcionesPrimerHijo',
            'respuestas',
            'opcionesEjercicio',
            'opcionesAlcohol',
            'opcionesMenstruacion'
        ));

    }

    /**
     * Guardar historial y calcular riesgo
     */
    public function guardar(Request $request, $id_paciente)
    {
        $validated = $request->validate([
            'edad' => 'required|integer|min:0',
            'id_mamografia' => 'required|exists:respuestas_binarias,id_respuesta',
            'id_diagnostico_previo' => 'required|exists:respuestas_binarias,id_respuesta',
            'id_familiar_primer_grado' => 'required|exists:respuestas_binarias,id_respuesta',
            'id_familiar_segundo_grado' => 'required|exists:respuestas_binarias,id_respuesta',
            'id_ejercicio' => 'required|exists:opciones_ejercicio,id_ejercicio',
            'id_alcohol' => 'required|exists:opciones_alcohol,id_alcohol',
            'id_menstruacion' => 'required|exists:opciones_menstruacion,id_menstruacion',
            'id_primer_hijo' => 'required|exists:opciones_primer_hijo,id_primer_hijo',
        ]);

        // Crear historial principal
        $historial = PacienteHistorial::create([
            'id_paciente' => $id_paciente,
            'id_medico' => session('usuario')->id_usuario,
            'fecha_registro' => now(),
            'Riesgo' => null,
            'edad' => $request->edad
        ]);

        // Crear registros hijos según nuevas FK
        $historial->antecedentes()->create([
            'id_mamografia' => $request->id_mamografia,
            'id_diagnostico_previo' => $request->id_diagnostico_previo,
        ]);

        $historial->familiares()->create([
            'id_familiar_primer_grado' => $request->id_familiar_primer_grado,
            'id_familiar_segundo_grado' => $request->id_familiar_segundo_grado,
        ]);

        $historial->habitos()->create([
            'id_ejercicio' => $request->id_ejercicio,
            'id_alcohol' => $request->id_alcohol,
        ]);

        $historial->reproductivos()->create([
            'id_menstruacion' => $request->id_menstruacion,
            'id_primer_hijo' => $request->id_primer_hijo,
        ]);

        // === Ejecutar el modelo de Machine Learning ===
        $command = "python3 " . base_path('python_model/predict.py') . " "
            . escapeshellarg($request->edad) . " "
            . escapeshellarg($request->id_familiar_primer_grado) . " "
            . escapeshellarg($request->id_familiar_segundo_grado) . " "
            . escapeshellarg($request->id_diagnostico_previo) . " "
            . escapeshellarg($request->id_menstruacion) . " "
            . escapeshellarg($request->id_primer_hijo) . " "
            . escapeshellarg($request->id_ejercicio) . " "
            . escapeshellarg($request->id_alcohol) . " "
            . escapeshellarg($request->id_mamografia);

        $prediccion = trim(shell_exec($command));
        if ($prediccion === null || $prediccion === "") $prediccion = 0;

        $mapaRiesgo = [
            0 => 'Bajo',
            1 => 'Moderado',
            2 => 'Alto'
        ];
        $riesgoTexto = $mapaRiesgo[$prediccion] ?? 'Desconocido';

        $historial->Riesgo = $prediccion;
        $historial->save();

        return redirect()->route('pacientes.ver', $id_paciente)
            ->with('success', "Historial registrado y riesgo calculado. Riesgo de cáncer: $riesgoTexto")
            ->with('riesgo', $riesgoTexto);

    }
}
