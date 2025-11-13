<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'fecha_nacimiento' => 'required|date',
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

        // Calcular edad a partir de fecha de nacimiento del formulario
        $edad = \Carbon\Carbon::parse($validated['fecha_nacimiento'])->age;

        // Redirige al formulario de historial pasando el id del paciente recién creado
        return redirect()->route('pacientes.historial.crear', ['id' => $paciente->id_paciente, 'edad' => $edad]);
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

        $historiales = $paciente->historiales()
            ->with(['antecedentes', 'familiares', 'habitos', 'reproductivos','medico'])
            ->orderBy('fecha_registro', 'asc')
            ->get();

        return view('medico.verpaciente', compact('paciente', 'historiales'));
}

}
