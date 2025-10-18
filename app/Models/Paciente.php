<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes_registros';
    protected $primaryKey = 'id_paciente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'rut',
        'sexo',
        'id_medico',
        'fecha_registro',
    ];

    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'id_medico', 'id_usuario');
    }

    public function historiales()
    {
        return $this->hasMany(PacienteHistorial::class, 'id_paciente', 'id_paciente');
    }
}
