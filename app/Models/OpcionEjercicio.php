<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionEjercicio extends Model
{
    protected $table = 'opciones_ejercicio';
    protected $primaryKey = 'id_ejercicio';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
