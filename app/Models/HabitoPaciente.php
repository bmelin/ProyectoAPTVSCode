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
        'Ejercicio',
        'Alcohol',
    ];

    public function historial()
    {
        return $this->belongsTo(PacienteHistorial::class, 'id_historial', 'id_historial');
    }
}
