<?php

namespace App\Exports;

use App\Models\Person;
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
        return Person::join('providers', 'providers.person_id', 'people.id')
            ->select('id', 'last_name', 'first_name', 'father_name',
                'establishment', 'address', 'phone1', 'phone2',
                'created_at', 'updated_at')
            ->get();
    }

    public function headings(): array
    {
        return ["رقم المزود", "اللقب", "الإسم", "اسم الأب", "المؤسسة", "العنوان", "رقم الهاتف 1", "رقم الهاتف 2",
            "تاريخ الإضافة", "تاريخ التعديل"];
    }
}
