<?php

namespace App\Exports;

use App\Models\Person;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Person::join('clients','clients.person_id','people.id')
            ->select('id', 'last_name', 'first_name', 'father_name',
                'address', 'phone1', 'phone2',
                'created_at', 'updated_at')
            ->get();
    }

    public function headings(): array
    {
        return ["رقم الزبون", "اللقب", "الإسم", "اسم الأب", "العنوان", "رقم الهاتف 1", "رقم الهاتف 2",
            "تاريخ الإضافة", "تاريخ التعديل"];
    }

}
