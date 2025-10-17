<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Muestra el formulario de creación
    public function crear()
    {
        return view('medico.registrarpaciente');
    }

    // Guarda el nuevo paciente en la BD
    public function guardar(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'rut' => 'required|string|max:12',
            'edad' => 'required|integer|min:15',
            'sexo' => 'required|in:M,F',
            'FamiliarPrimerGradoCC' => 'required|boolean',
            'FamiliarSegundoGradoCC' => 'required|boolean',
            'DiagnosticoPrevioCancer' => 'required|boolean',
            'Ejercicio' => 'required|in:nunca,menos_de_3,3_a_4,mas_de_4',
            'Alcohol' => 'required|in:nunca,ocasional,frecuente,diario',
            'Mamografia' => 'required|boolean',
            'Menstruacion' => 'required|in:menos_de_12,12_a_13,mayor_de_14',
            'PrimerHijo' => 'required|in:nunca,menor_a_30,mayor_a_30',
            'id_medico' => 'required|exists:usuarios,id_usuario'
        ]);

        // ✅ Crear paciente
        $paciente = new Paciente();
        $paciente->nombre = $request->nombre;
        $paciente->rut = $request->rut;
        $paciente->edad = $request->edad;
        $paciente->sexo = $request->sexo;
        $paciente->id_medico = $request->id_medico;
        $paciente->fecha_registro = now(); // Fecha actual
        $paciente->FamiliarPrimerGradoCC = $request->FamiliarPrimerGradoCC;
        $paciente->FamiliarSegundoGradoCC = $request->FamiliarSegundoGradoCC;
        $paciente->DiagnosticoPrevioCancer = $request->DiagnosticoPrevioCancer;
        $paciente->Ejercicio = $request->Ejercicio;
        $paciente->Alcohol = $request->Alcohol;
        $paciente->Mamografia = $request->Mamografia;
        $paciente->Menstruacion = $request->Menstruacion;
        $paciente->PrimerHijo = $request->PrimerHijo;
        $paciente->save();

        // Redirigir al panel medico con mensaje
        return redirect()->route('medico.dashboard')->with('success', 'Paciente registrado exitosamente.');
    }
}