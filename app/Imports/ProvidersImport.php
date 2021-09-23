<?php

namespace App\Imports;

use App\Models\Provider;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProvidersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Provider([
            'last_name'    => $row[0],
            'first_name'    => $row[1],
            'father_name'    => $row[2],
            'establishment'    => $row[3],
            'address'    => $row[4],
            'phone1'    => $row[5],
            'phone2'    => $row[6],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
