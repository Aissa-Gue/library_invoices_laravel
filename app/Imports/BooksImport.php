<?php

namespace App\Imports;

use App\Models\Book;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class BooksImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Book([
            'title' => $row[0],
            'author' => $row[1],
            'investigator' => $row[2],
            'translator' => $row[3],
            'publisher' => $row[4],
            'publication_year' => $row[5],
            'edition' => $row[6],
            'quantity' => $row[7],
            'purchase_price' => $row[8],
            'sale_percentage' => $row[9],
            'discount' => $row[10],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
