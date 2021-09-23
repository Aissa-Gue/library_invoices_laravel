<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;


class BooksExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::all();
    }

    public function headings(): array
    {
        return ["رقم الكتاب", "العنوان", "المؤلف","المحقق", "المترجم", "الناشر","سنة النشر",
            "الطبعة", "الكمية","سعر الشراء", "نسبة البيع","إمكانية التخفيض",
            "تاريخ الإضافة", "تاريخ التعديل"];
    }
}
