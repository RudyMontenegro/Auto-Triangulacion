<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tigoExcel extends Model
{
    protected $fillable = [
        'llamada','numeroA', 'numeroB','fecha','tiempo','ciudad','sitio', 'longitud', 'latitud', 'punto_cardinal',
    ];
}
