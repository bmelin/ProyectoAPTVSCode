<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactorReproductivo extends Model
{
    use HasFactory;

    protected $table = 'factores_reproductivos';
    protected $primaryKey = 'id_factor';
    public $timestamps = false;

    protected $fillable = [
        'id_historial',
        'Menstruacion',
        'PrimerHijo',
    ];

    public function historial()
    {
        return $this->belongsTo(PacienteHistorial::class, 'id_historial', 'id_historial');
    }
}
