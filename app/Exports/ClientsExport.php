<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::all();
    }

    public function headings(): array
    {
        return ["رقم الزبون", "اللقب", "الإسم","اسم الأب", "العنوان", "رقم الهاتف 1","رقم الهاتف 2",
            "تاريخ الإضافة", "تاريخ التعديل"];
    }

}
