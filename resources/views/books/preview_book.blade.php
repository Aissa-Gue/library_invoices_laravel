@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center py-3  fs-5">معلومات الكتاب</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الكتاب:</th>
                    <td class="col-md-9">{{$book->id}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">العنوان:</th>
                    <td class="col-md-9">{{$book->title}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">المؤلف:</th>
                    <td class="col-md-9">{{$book->author}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">المحقق:</th>
                    <td class="col-md-9">{{$book->investigator}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">المترجم:</th>
                    <td class="col-md-9">{{$book->translator}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">الناشر:</th>
                    <td class="col-md-9">{{$book->publisher}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">سنة النشر:</th>
                    <td class="col-md-9">{{$book->publication_year}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">الطبعة:</th>
                    <td class="col-md-9">{{$book->edition}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center py-3 fs-5">التفاصيل</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row py-1">
                    <th class="col-md-5">الكمية:</th>
                    <td class="col-md-6">{{$book->quantity}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">إمكانية التخفيض:</th>
                    <td class="col-md-6">
                        @if($book->discount == 1) {{'نعم'}}
                        @elseif($book->discount == 0) {{'لا'}}@endif
                    </td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">نسبة البيع:</th>
                    <td class="col-md-6">{{$book->sale_percentage}} %</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">سعر الشراء:</th>
                    <td class="col-md-6">{{$book->purchase_price}}.00 دج</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">سعر البيع:</th>
                    <td class="col-md-6">{{$book->purchase_price + ($book->purchase_price * $book->sale_percentage / 100)}}.00 دج</td>
                </tr>
                <tr class="row mt-4">
                    <td class="col-md-11 text-center">
                        <a href="{{route('editBook', $book->id)}}" class="btn btn-primary px-4">تعديل</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{route('deleteBook', $book->id)}}" class="btn btn-danger px-4"
                               onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
