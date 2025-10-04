<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica que esté logueado
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        // Verifica que sea admin
        if (Auth::user()->rol !== 'admin') {
            abort(403); // usuario logueado pero no admin
        }

        return $next($request);
    }
}
