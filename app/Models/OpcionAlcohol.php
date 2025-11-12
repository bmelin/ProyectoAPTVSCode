<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionAlcohol extends Model
{
    protected $table = 'opciones_alcohol';
    protected $primaryKey = 'id_alcohol';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
