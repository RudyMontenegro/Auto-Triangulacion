<?php

namespace App;

use Maatwebsite\Excel\Concerns\ToModel;

class excelModel implements ToModel
{
    public function model(array $row)
    {
    

        return new tigo([
            'llamada' => $row[0],
            'numeroA' => $row[1],
            'numeroB' => $row[2],
            'fecha' => $row[3],
            'tiempo' => $row[4],
            'longitud' => $row[9],
            'latitud' => $row[10],
            
        ]);
    }
}