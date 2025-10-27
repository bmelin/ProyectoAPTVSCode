<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteHistorial;
use App\Models\Paciente;

class PacienteHistorialController extends Controller
{
    // Mostrar formulario historial
    public function crear($id_paciente)
    {
        $paciente = \App\Models\Paciente::findOrFail($id_paciente);
        $tieneHistorial = $paciente->historiales()->exists();
        $menstruacion = null;

        // Si ya tiene historial, tomamos el valor del primer registro
        if ($tieneHistorial) {
            $menstruacion = $paciente->historiales()->first()->Menstruacion;
        }

        return view('medico.registrarhistorial', compact('id_paciente', 'tieneHistorial', 'menstruacion', 'paciente'));
    }

    // Guardar historial
    public function guardar(Request $request, $id_paciente)
    {
        $validated = $request->validate([
            'edad' => 'required|integer|min:0',
            'Mamografia' => 'required|boolean',
            'FamiliarPrimerGradoCC' => 'required|boolean',
            'FamiliarSegundoGradoCC' => 'required|boolean',
            'DiagnosticoPrevioCancer' => 'required|boolean',
            'Ejercicio' => 'required|string',
            'Alcohol' => 'required|string',
            'Menstruacion' => 'required|string',
            'PrimerHijo' => 'required|string',
        ]);

        $validated['id_paciente'] = $id_paciente;
        $validated['id_medico'] = session('usuario')->id_usuario;
        $validated['fecha_registro'] = now();

        PacienteHistorial::create($validated);

        // 🔹 Buscar el paciente con sus historiales
        $paciente = Paciente::findOrFail($id_paciente);
        $historiales = $paciente->historiales()->orderBy('fecha_registro', 'asc')->get();

        // 🔹 Redirigir a la vista del paciente con mensaje de éxito
        return redirect()
            ->route('pacientes.ver', $id_paciente)
            ->with('success', 'Historial del paciente registrado correctamente.');
    }
}
