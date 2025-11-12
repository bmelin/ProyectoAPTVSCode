<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionPrimerHijo extends Model
{
    protected $table = 'opciones_primer_hijo';
    protected $primaryKey = 'id_primer_hijo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
