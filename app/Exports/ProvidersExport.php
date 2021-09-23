<?php

namespace App\Exports;

use App\Models\Provider;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProvidersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Provider::all();
    }

    public function headings(): array
    {
        return ["رقم المزود", "اللقب", "الإسم","اسم الأب", "المؤسسة","العنوان", "رقم الهاتف 1","رقم الهاتف 2",
            "تاريخ الإضافة", "تاريخ التعديل"];
    }
}
