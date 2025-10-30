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
        'fecha_registro',
        'Riesgo',
        'edad',
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

    // Relaciones con las nuevas tablas
    public function antecedentes()
    {
        return $this->hasOne(AntecedentePaciente::class, 'id_historial', 'id_historial');
    }

    public function familiares()
    {
        return $this->hasOne(AntecedenteFamiliar::class, 'id_historial', 'id_historial');
    }

    public function habitos()
    {
        return $this->hasOne(HabitoPaciente::class, 'id_historial', 'id_historial');
    }

    public function reproductivos()
    {
        return $this->hasOne(FactorReproductivo::class, 'id_historial', 'id_historial');
    }

}