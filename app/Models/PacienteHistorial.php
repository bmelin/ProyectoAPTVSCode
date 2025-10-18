<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\Models\Usuario;
use Carbon\Carbon;

class PacienteHistorial extends Model
{
    use HasFactory;

    protected $table = 'pacientes_historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'id_medico',
        'edad',
        'Mamografia',
        'FamiliarPrimerGradoCC',
        'FamiliarSegundoGradoCC',
        'DiagnosticoPrevioCancer',
        'Ejercicio',
        'Alcohol',
        'Menstruacion',
        'PrimerHijo',
        'fecha_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'id_medico', 'id_usuario');
    }
}