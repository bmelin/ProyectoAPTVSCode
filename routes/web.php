<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'guardar'])->name('usuarios.guardar');
});