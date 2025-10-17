<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si hay usuario logueado y si su rol es admin
        if (!session('usuario') || session('usuario')->rol !== 'admin') {
            abort(403); // Prohibido
        }

        return $next($request);
    }
}
