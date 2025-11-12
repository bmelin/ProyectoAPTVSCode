<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaBinaria extends Model
{
    protected $table = 'respuestas_binarias';
    protected $primaryKey = 'id_respuesta';
    public $timestamps = false;
    protected $fillable = ['descripcion'];

    public function antecedentesPaciente()
    {
        return $this->hasMany(AntecedentePaciente::class, 'id_mamografia');
    }

    public function antecedentesDiagnostico()
    {
        return $this->hasMany(AntecedentePaciente::class, 'id_diagnostico_previo');
    }
}
