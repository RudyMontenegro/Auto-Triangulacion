<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tigo extends Model
{
    protected $fillable = [
        'llamada','numeroA', 'numeroB','fecha','tiempo','ciudad','sitio', 'longitud', 'latitud', 'punto_cardinal',
    ];
}
