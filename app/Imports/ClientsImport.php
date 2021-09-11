<?php

namespace App\Imports;

use App\Models\Client;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ClientsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'last_name'    => $row[0],
            'first_name'    => $row[1],
            'father_name'    => $row[2],
            'address'    => $row[3],
            'phone1'    => $row[4],
            'phone2'    => $row[5],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
