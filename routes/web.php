<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PacienteHistorialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas para login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// Vistas protegidas por rol
Route::get('/admin', function() {
    if (session('usuario')->rol !== 'admin') abort(403);
    return view('admin.inicio');
})->name('admin.dashboard');

Route::get('/medico', function() {
    if (session('usuario')->rol !== 'medico') abort(403);
    return view('medico.inicio');
})->name('medico.dashboard');



// Rutas para gestionar usuarios
Route::middleware(['admin'])->group(function () {
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'guardar'])->name('usuarios.guardar');
});

Route::middleware(['admin'])->group(function () {
    // Listar usuarios
    Route::get('/usuarios', [UsuarioController::class, 'listar'])->name('usuarios.listar');
    // Formulario para editar usuario
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
    // Actualizar usuario
    Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizar'])->name('usuarios.actualizar');
    // Eliminar usuario
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminar'])->name('usuarios.eliminar');
});




// Rutas para gestionar pacientes
Route::middleware(['medico'])->group(function () {
    //formulario datos fijos
    Route::get('/pacientes/crear', [PacienteController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes/guardar', [PacienteController::class, 'guardar'])->name('pacientes.guardar');

    //formulario datos que cambian
    Route::get('/pacientes/{id}/historial/crear', [PacienteHistorialController::class, 'crear'])->name('pacientes.historial.crear');
    Route::post('/pacientes/{id}/historial/guardar', [PacienteHistorialController::class, 'guardar'])->name('pacientes.historial.guardar');
});