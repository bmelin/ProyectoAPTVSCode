<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionMenstruacion extends Model
{
    protected $table = 'opciones_menstruacion';
    protected $primaryKey = 'id_menstruacion';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
