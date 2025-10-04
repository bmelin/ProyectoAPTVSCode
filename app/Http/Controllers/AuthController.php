<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        $usuario = Usuario::where('correo', $credentials['correo'])->first();

        if ($usuario && Hash::check($credentials['contrasena'], $usuario->contrasena)) {
            session(['usuario' => $usuario]);

            if ($usuario->rol === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($usuario->rol === 'medico') {
                return redirect()->route('medico.dashboard');
            }
        }

        return back()->withErrors(['correo' => 'Credenciales inválidas']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login.form');
    }
}