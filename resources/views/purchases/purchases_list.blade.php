@extends('layouts.master')

@section('content')
    @include('includes.navbars.orders-purchases.navigation_list')

    <div class="alert alert-primary text-center" role="alert">
        <h4>قائمة فواتير المزودين</h4>
    </div>

    <form action="{{Route('purchasesList')}}" method="get">
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">رقم الفاتورة</span>
                            <input type="text" pattern="\d*" name="purchase_id" class="form-control"
                                   placeholder="أدخل رقم الفاتورة" value="{{request('purchase_id')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">المؤسسة</span>
                            <input type="text" name="establishment" class="form-control"
                                   placeholder="أدخل اسم المؤسسة" value="{{request('establishment')}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">	&nbsp;	&nbsp;لقب المزود</span>
                            <input type="text" name="last_name" class="form-control" placeholder="أدخل لقب المزود"
                                   value="{{request('last_name')}}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">اسم المزود</span>
                            <input type="text" name="first_name" class="form-control" placeholder="أدخل اسم المزود"
                                   value="{{request('first_name')}}">
                            <button type="submit" class="btn btn-primary">بحث</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <div class="alert alert-warning text-center" role="alert">
        <strong> عدد النتائج = </strong> {{$purchases->total()}}
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col" class="text-center"><i class="fas fa-radiation text-secondary fs-5"></i></th>
            <th scope="col" class="text-center">رقم الفاتورة</th>
            <th scope="col">تاريخ الفاتورة</th>
            <th scope="col">الزبون</th>
            <th scope="col" class="text-center">تفاصيل</th>
            <th scope="col" class="text-center">تعديل</th>
            <th scope="col" class="text-center">حذف</th>
        </tr>
        </thead>
        <tbody>
        @forelse($purchases as $purchase)
        @empty
            <div class="alert alert-danger text-center" role="alert">
                لا توجد نتائج مطابقة لـ:
                <strong>{{request('purchase_id')}}
                    ~ {{request('last_name')}} {{request('first_name')}}</strong>
            </div>
        @endforelse

        @foreach($purchases as $purchase)
            <tr>
                <th scope="row" class="text-center fs-5">
                    @if($purchase->required_amount == $purchase->paid_amount)
                        <i class="fas fa-shield-check text-success"></i>
                    @elseif($purchase->required_amount > $purchase->paid_amount and $purchase->paid_amount == 0)
                        <i class="fas fa-times-circle text-danger"></i>
                    @elseif($purchase->required_amount > $purchase->paid_amount)
                        <i class="fas fa-exclamation-circle text-warning"></i>
                    @endif
                </th>
                <th scope="row" class="text-center">{{$purchase->id}}</th>
                <td>{{$purchase->created_at}}</td>
                <td>{{$purchase->last_name.' '.$purchase->first_name.' بن '.$purchase->father_name}}
                </td>

                <td class="text-center">
                    <a class="btn btn-outline-success"
                       href="{{route('previewPurchase', $purchase->id)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                            <path
                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                        </svg>
                    </a>
                </td>

                <td class="text-center">
                    <a class="btn btn-outline-primary"
                       href="{{route('editPurchase', $purchase->id)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                    </a>
                </td>
                <td class="text-center">
                    <form action="{{route('deletePurchase', $purchase->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger"
                                type="submit"
                                onclick="return confirm('هل أنت متأكد؟')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="row justify-content-center fixed-bottom">
        <div class="offset-2 col-md-auto">
            {{$purchases->links()}}
        </div>
    </div>
@endsection
