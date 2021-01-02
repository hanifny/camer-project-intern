<?php

namespace App\Imports;

use App\Unit;
use Maatwebsite\Excel\Concerns\ToModel;

class UnitImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Unit([
            'unit_code' => $row[0],
            'floor' => explode('-', $row[0])[1], 
        ]);
    }
}
