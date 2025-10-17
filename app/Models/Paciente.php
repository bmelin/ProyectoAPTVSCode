<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario; // Importa el modelo Usuario para la relación

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes_registros';
    protected $primaryKey = 'id_paciente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'rut',
        'edad',
        'sexo',
        'fecha_registro',
        'id_medico',
        'FamiliarPrimerGradoCC',
        'FamiliarSegundoGradoCC',
        'DiagnosticoPrevioCancer',
        'Ejercicio',
        'Alcohol',
        'Mamografia',
        'Menstruacion',
        'PrimerHijo'
    ];

    // Relación con el médico que registró al paciente
    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'id_medico', 'id_usuario');
    }
}
