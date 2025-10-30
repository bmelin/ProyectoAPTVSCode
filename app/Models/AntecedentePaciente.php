<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentePaciente extends Model
{
    use HasFactory;

    protected $table = 'antecedentes_paciente';
    protected $primaryKey = 'id_antecedente';
    public $timestamps = false;

    protected $fillable = [
        'id_historial',
        'Mamografia',
        'DiagnosticoPrevioCancer',
    ];

    public function historial()
    {
        return $this->belongsTo(PacienteHistorial::class, 'id_historial', 'id_historial');
    }
}
