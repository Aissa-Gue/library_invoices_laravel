@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center py-3  fs-5">معلومات الزبون</th>
                </tr>
                </thead>
                <tbody>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الزبون:</th>
                    <td class="col-md-9">{{$client->id}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">اللقب:</th>
                    <td class="col-md-9">{{$client->last_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">الاسم:</th>
                    <td class="col-md-9">{{$client->first_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">اسم الأب:</th>
                    <td class="col-md-9">{{$client->father_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">العنوان:</th>
                    <td class="col-md-9">{{$client->address}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الهاتف 1:</th>
                    <td class="col-md-9">0{{$client->phone1}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الهاتف 2:</th>
                    <td class="col-md-9">0{{$client->phone2}}</td>
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
                    <th class="col-md-5">عدد الفواتير:</th>
                    <td class="col-md-6">{{$details->total_orders}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">المبلغ الإجمالي:</th>
                    <td class="col-md-6">{{number_format($details->total_amount,2)}} دج </td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">تاريخ الإنشاء:</th>
                    <td class="col-md-6">{{$client->created_at}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">تاريخ آخر تعديل:</th>
                    <td class="col-md-6">{{$client->updated_at}}</td>
                </tr>
                <tr class="row mt-4">
                    <td class="col-md-11 text-center">
                        <a href="{{route('editClient', $client->id)}}" class="btn btn-primary px-4">تعديل</a>
                        <a href="{{route('deleteClient', $client->id)}}" class="btn btn-danger px-4"
                           onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
