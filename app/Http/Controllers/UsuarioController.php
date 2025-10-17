<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Muestra el formulario de creación
    public function crear()
    {
        return view('admin.crearusuario');
    }

    // Guarda el nuevo usuario en la BD
    public function guardar(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6',
            'rol' => 'required|in:admin,medico'
        ]);

        // Crear usuario
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->contrasena = bcrypt($request->contrasena); // Encriptar contraseña
        $usuario->rol = $request->rol;
        $usuario->save();

        // Redirigir al panel admin con mensaje
        return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente.');
    }

    //Listar usuarios
    public function listar()
    {
        $usuarios = Usuario::all(); // Trae todos los usuarios
        return view('admin.listausuarios', compact('usuarios'));
    }

    //Formulario para editar usuario
    public function editar($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.editarusuario', compact('usuario'));
    }

    //Actualizar usuario
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $id . ',id_usuario',
            'contrasena' => 'nullable|min:6',
            'rol' => 'required|in:admin,medico'
        ]);   
             
        $usuario = Usuario::findOrFail($id);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;

        // Solo actualiza la contraseña si el campo no viene vacío
        if (!empty($request->contrasena)) {
            $usuario->contrasena = bcrypt($request->contrasena); // ✅ usando bcrypt
        }

        $usuario->rol = $request->rol;
        $usuario->save();

        return redirect()->route('usuarios.listar')->with('success', 'Usuario actualizado correctamente');
    }


    //Eliminar usuario
    public function eliminar($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.listar')->with('success', 'Usuario eliminado correctamente');
    }

}