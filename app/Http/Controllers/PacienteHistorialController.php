<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteHistorial;
use App\Models\Paciente;
use Carbon\Carbon;


class PacienteHistorialController extends Controller
{
    // Mostrar formulario historial
    public function crear(Request $request, $id_paciente)
    {
        $paciente = \App\Models\Paciente::findOrFail($id_paciente);

        // Revisar si hay historiales
        $tieneHistorial = $paciente->historiales()->exists();

        // Inicializar variables
        $ultimoHistorial = null;
        $edad = $request->edad ?? null; // edad pasada desde el registro del paciente
        $menstruacion = null;
        $primerHijo = null;
        $antecedentes = [
            'FamiliarPrimerGradoCC' => null,
            'FamiliarSegundoGradoCC' => null,
            'DiagnosticoPrevioCancer' => null,
        ];

        if ($tieneHistorial) {
            // Tomar el último historial
            $ultimoHistorial = $paciente->historiales()
                ->latest('fecha_registro')
                ->with(['antecedentes', 'familiares', 'reproductivos'])
                ->first();

            // Calcular la edad actualizada sumando los años transcurridos desde el último historial
            if ($ultimoHistorial->edad !== null && $ultimoHistorial->fecha_registro !== null) {
                $fechaUltimo = \Carbon\Carbon::parse($ultimoHistorial->fecha_registro);
                $edadTranscurrida = $fechaUltimo->diffInYears(now());
                $edad = $ultimoHistorial->edad + $edadTranscurrida;
            }

            // Menstruación
            $menstruacion = $ultimoHistorial->reproductivos->Menstruacion ?? null;

            // Primer hijo
            $primerHijo = $ultimoHistorial->reproductivos->PrimerHijo ?? null;

            // Antecedentes familiares
            $antecedentes['FamiliarPrimerGradoCC'] = $ultimoHistorial->familiares->FamiliarPrimerGradoCC ?? null;
            $antecedentes['FamiliarSegundoGradoCC'] = $ultimoHistorial->familiares->FamiliarSegundoGradoCC ?? null;
            $antecedentes['DiagnosticoPrevioCancer'] = $ultimoHistorial->antecedentes->DiagnosticoPrevioCancer ?? null;
        }

        // Determinar opciones de PrimerHijo según edad
        $opcionesPrimerHijo = [];
        if ($edad !== null) {
            if ($edad < 30) {
                $opcionesPrimerHijo = ['nunca' => 'No ha tenido hijos', 'menor_a_30' => 'Menor a 30 años'];
            } else {
                $opcionesPrimerHijo = ['nunca' => 'No ha tenido hijos', 'mayor_a_30' => 'Mayor a 30 años'];
            }
        }

        // Determinar si el campo PrimerHijo debe estar bloqueado (si ya se seleccionó una opción no cambiable)
        $primerHijoBloqueado = false;
        if ($ultimoHistorial && in_array($primerHijo, ['menor_a_30', 'mayor_a_30'])) {
            $primerHijoBloqueado = true;
        }

        return view('medico.registrarhistorial', compact(
            'id_paciente',
            'edad',
            'tieneHistorial',
            'menstruacion',
            'primerHijo',
            'antecedentes',
            'opcionesPrimerHijo',
            'primerHijoBloqueado'
        ));
    }




    public function guardar(Request $request, $id_paciente)
    {
        // Validar solo los campos que vienen del formulario
        $validated = $request->validate([
            'edad' => 'required|integer|min:0',

            // booleanos
            'Mamografia' => 'required|in:1,0',
            'FamiliarPrimerGradoCC' => 'required|in:1,0',
            'FamiliarSegundoGradoCC' => 'required|in:1,0',
            'DiagnosticoPrevioCancer' => 'required|in:1,0',

            // strings categóricas
            'Ejercicio' => 'required|in:nunca,menos_de_3,3_a_4,mas_de_4',
            'Alcohol' => 'required|in:nunca,ocasional,frecuente,diario',

            // strings categóricas (pero inmovibles después de 1er registro)
            'Menstruacion' => 'required|in:menos_de_12,12_a_13,mayor_de_14',
            'PrimerHijo' => 'required|in:nunca,menor_a_30,mayor_a_30',
        ]);


        // 1️⃣ Crear el historial principal (tabla madre)
        $historial = \App\Models\PacienteHistorial::create([
            'id_paciente' => $id_paciente,
            'id_medico' => session('usuario')->id_usuario,
            'fecha_registro' => now(),
            'Riesgo' => null, // temporalmente, hasta integrar el modelo ML
            'edad' => $request->edad
        ]);

        // 2️⃣ Crear registros en las tablas hijas
        $historial->antecedentes()->create([
            'Mamografia' => $request->Mamografia,
            'DiagnosticoPrevioCancer' => $request->DiagnosticoPrevioCancer,
        ]);

        $historial->familiares()->create([
            'FamiliarPrimerGradoCC' => $request->FamiliarPrimerGradoCC,
            'FamiliarSegundoGradoCC' => $request->FamiliarSegundoGradoCC,
        ]);

        $historial->habitos()->create([
            'Ejercicio' => $request->Ejercicio,
            'Alcohol' => $request->Alcohol,
        ]);

        $historial->reproductivos()->create([
            'Menstruacion' => $request->Menstruacion,
            'PrimerHijo' => $request->PrimerHijo,
        ]);

        // 3️⃣ Obtener datos para mostrar en la vista
        $paciente = \App\Models\Paciente::findOrFail($id_paciente);
        $historiales = $paciente->historiales()->orderBy('fecha_registro', 'asc')->get();

        // 4️⃣ Redirigir con mensaje de éxito
        return redirect()
            ->route('pacientes.ver', $id_paciente)
            ->with('success', 'Historial del paciente registrado correctamente.');
    }

}
