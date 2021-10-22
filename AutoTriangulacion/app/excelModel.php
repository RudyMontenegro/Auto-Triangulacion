<?php

namespace App;

use Maatwebsite\Excel\Concerns\ToModel;

class excelModel implements ToModel
{
    public function model(array $row)
    {
    

        return new excel([
            'numeroA' => $row[2],
            'numeroB' => $row[7],
        ]);
    }
}
