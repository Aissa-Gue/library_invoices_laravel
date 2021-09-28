@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center py-3  fs-5">معلومات المزود</th>
                </tr>
                </thead>
                <tbody>
                @if(session()->has('clientExistAlert'))
                    <tr class="alert alert-danger alert-dismissible d-flex align-items-center fw-bold mt-1"
                        role="alert">
                        <th>
                            <i class="fas fa-times-circle me-2 fs-5"></i>
                            <span>
                                {{session()->get('clientExistAlert')}}
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </th>
                    </tr>
                @endif
                <tr class="row py-1">
                    <th class="col-md-2">رقم المزود:</th>
                    <td class="col-md-9">{{$provider->person->id}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">اللقب:</th>
                    <td class="col-md-9">{{$provider->person->last_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">الاسم:</th>
                    <td class="col-md-9">{{$provider->person->first_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">اسم الأب:</th>
                    <td class="col-md-9">{{$provider->person->father_name}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">المؤسسة:</th>
                    <td class="col-md-9">{{$provider->person->establishment}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">العنوان:</th>
                    <td class="col-md-9">{{$provider->person->address}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الهاتف 1:</th>
                    <td class="col-md-9">0{{$provider->person->phone1}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-2">رقم الهاتف 2:</th>
                    <td class="col-md-9">0{{$provider->person->phone2}}</td>
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
                    <td class="col-md-6 text-primary fw-bold">{{$details->total_purchases}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">مجموع الفواتير:</th>
                    <td class="col-md-6 text-success fw-bold">{{number_format($details->total_required_amount,2)}}دج
                    </td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">مجموع الديون:</th>
                    <td class="col-md-6 text-danger fw-bold">{{number_format($details->total_debts,2)}} دج</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">تاريخ الإنشاء:</th>
                    <td class="col-md-6">{{$provider->created_at}}</td>
                </tr>
                <tr class="row py-1">
                    <th class="col-md-5">تاريخ آخر تعديل:</th>
                    <td class="col-md-6">{{$provider->updated_at}}</td>
                </tr>
                <tr class="row mt-4">
                    <td class="col-md-11 text-center">
                        <form action="{{route('addAsClient', $provider->person->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success px-4"><i class="fas fa-user-plus"></i> إضافة
                                كزبون
                            </button>
                        </form>
                    </td>
                </tr>
                <tr class="row py-1">
                    <td class="col-md-11 text-center">
                        <a href="{{route('editProvider', $provider->person->id)}}" class="btn btn-primary px-4"><i
                                class="fas fa-user-edit"></i> تعديل</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{route('deleteProvider', $provider->person->id)}}" class="btn btn-danger px-4"
                               onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-user-times"></i> حذف</a>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
