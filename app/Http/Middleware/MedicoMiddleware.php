<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MedicoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Verificamos que el usuario está en sesión y que es médico
        if (!session('usuario') || session('usuario')->rol !== 'medico') {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
