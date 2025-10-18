<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Muestra el formulario de creación del paciente (datos fijos)
    public function crear()
    {
        return view('medico.registrarpaciente');
    }

    // Guarda los datos fijos en pacientes_registros y redirige al formulario de historial
    public function guardar(Request $request)
    {
        // Validación solo de los datos fijos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:pacientes_registros,rut',
            'sexo' => 'required|in:M,F',
            'id_medico' => 'required|exists:usuarios,id_usuario'
        ]);

        // Crear paciente maestro
        $paciente = Paciente::create([
            'nombre' => $request->nombre,
            'rut' => $request->rut,
            'sexo' => $request->sexo,
            'id_medico' => $request->id_medico,
            'fecha_registro' => now(),
        ]);

        // Redirige al formulario de historial pasando el id del paciente recién creado
        return redirect()->route('pacientes.historial.crear', ['id' => $paciente->id_paciente]);
    }

    // Mostrar el formulario de búsqueda
    public function buscarVista()
    {
        return view('medico.buscarpaciente');
    }

    // Procesar la búsqueda por RUT
    public function buscar(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|max:12',
        ]);

        $paciente = Paciente::where('rut', $request->rut)->first();

        if (!$paciente) {
            return back()->withErrors(['rut' => 'No se encontró un paciente con ese RUT.']);
        }

        // Traer historiales ordenados por fecha
        $historiales = $paciente->historiales()->orderBy('fecha_registro', 'asc')->get();

        return view('medico.verpaciente', compact('paciente', 'historiales'));
    }

    public function verPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        $historiales = $paciente->historiales()->orderBy('fecha_registro', 'asc')->get();

        return view('medico.verpaciente', compact('paciente', 'historiales'));
    }
}
