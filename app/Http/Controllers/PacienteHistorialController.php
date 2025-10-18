<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PacienteHistorial;

class PacienteHistorialController extends Controller
{
    // Mostrar formulario historial
    public function crear($id_paciente)
    {
        return view('medico.registrarhistorial', compact('id_paciente'));
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

        return redirect()->route('medico.dashboard')->with('success', 'Historial del paciente registrado correctamente.');
    }
}
