<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tigo extends Model
{
    protected $fillable = [
        'numeroA', 'numeroB', 'llamada' ,'fecha','tiempo', 'longitud', 'latitud',
    ];
}
