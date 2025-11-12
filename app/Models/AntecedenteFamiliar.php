<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteFamiliar extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_familiares';
    protected $primaryKey = 'id_familiar';
    public $timestamps = false;

    protected $fillable = [
    'id_historial',
    'id_familiar_primer_grado',
    'id_familiar_segundo_grado',
    ];

    public function primerGrado()
    {
        return $this->belongsTo(RespuestaBinaria::class, 'id_familiar_primer_grado', 'id_respuesta');
    }

    public function segundoGrado()
    {
        return $this->belongsTo(RespuestaBinaria::class, 'id_familiar_segundo_grado', 'id_respuesta');
    }


    public function historial()
    {
        return $this->belongsTo(PacienteHistorial::class, 'id_historial', 'id_historial');
    }
}
