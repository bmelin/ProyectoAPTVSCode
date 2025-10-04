<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Admin',
            'correo' => 'admincancer@gmail.com',
            'contrasena' => Hash::make('AdmPM2025'),
            'rol' => 'admin',
            'fecha_creacion' => now(),
        ]);
        
        Usuario::create([
            'nombre' => 'Juan Pérez',
            'correo' => 'medicocancer@gmail.com',
            'contrasena' => Hash::make('DrPM2025'),
            'rol' => 'medico',
            'fecha_creacion' => now(),
        ]);

    }
}
