<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitoPaciente extends Model
{
    use HasFactory;

    protected $table = 'habitos_paciente';
    protected $primaryKey = 'id_habito';
    public $timestamps = false;

    protected $fillable = [
    'id_historial',
    'id_ejercicio',
    'id_alcohol',
    ];

    public function ejercicio()
    {
        return $this->belongsTo(OpcionEjercicio::class, 'id_ejercicio', 'id_ejercicio');
    }

    public function alcohol()
    {
        return $this->belongsTo(OpcionAlcohol::class, 'id_alcohol', 'id_alcohol');
    }


    public function historial()
    {
        return $this->belongsTo(PacienteHistorial::class, 'id_historial', 'id_historial');
    }
}
