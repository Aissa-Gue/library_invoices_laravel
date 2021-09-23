@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>معلومات الفاتورة</h4>
    </div>

    <!-- 1st row -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">معلومات الفاتورة</legend>
        <div class="row mt-3">
            <div class="col-md-4">
                <p><strong>رقم الفاتورة: </strong>{{$purchase->id}}</p>
            </div>
            <div class="col-md-4">
                <p><strong>تاريخ الفاتورة: </strong>{{$purchase->created_at}}</p>
            </div>
            <div class="col-md-4">
                <p><strong>تاريخ آخر تعديل: </strong>{{$purchase->updated_at}}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <p>
                    <strong>الزبون: </strong>{{$purchase->provider->last_name . ' ' . $purchase->provider->first_name . ' بن ' . $purchase->provider->father_name}}
                </p>
            </div>
            <div class="col-md-3">
                <p><strong>المبلغ المدفوع: </strong>{{number_format($purchase->paid_amount,2)}} دج </p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <p class="text-success fw-bold">
                    <strong class="text-dark me-2">البائع: </strong> <i
                        class="fas fa-user-shield"></i> {{$purchase->createdBy->username}}
                </p>
            </div>
            <div class="col-md-4">
                <p class="text-success fw-bold">
                    <strong class="text-dark me-2">المعدل: </strong> <i
                        class="fas fa-user-shield"></i> {{$purchase->updatedBy->username}}
                </p>
            </div>
        </div>
    </fieldset>

    <!-- 3rd row -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">قائمة الكتب</legend>
        <div class="row mt-3">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان الكتاب</th>
                    <th scope="col" class="text-center">نسبة البيع</th>
                    <th scope="col" class="text-center">سعر الشراء</th>
                    <th scope="col" class="text-center">سعر البيع</th>
                    <th scope="col" class="text-center">الكمية</th>
                    <th scope="col" class="text-center">إجمالي الشراء</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 0 @endphp
                @foreach($purchaseBooks as $purchaseBook)
                    <tr>
                        <th scope="row">{{++$i}}</th>
                        <td>{{$purchaseBook->book->title}}</td>
                        <td class="text-center">{{$purchaseBook->book->sale_percentage}}%</td>
                        <td class="text-center">{{number_format($purchaseBook->purchase_price,2)}}</td>
                        <td class="text-center">{{number_format($purchaseBook->purchase_price + ($purchaseBook->purchase_price * $purchaseBook->book->sale_percentage / 100),2)}}</td>
                        <td class="text-center">{{$purchaseBook->quantity}}</td>
                        <td class="text-center">{{number_format($purchaseBook->purchase_price * $purchaseBook->quantity,2)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <!-- END 3rd row -->
        <div class="row justify-content-md-end">
            <div class="col-md-4">
                <table class="table table-hover">
                    <thead>
                    <tr class="table-warning">
                        <th scope="col" colspan="2" class="text-center">التفاصيل
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" class="text-danger">عدد الكتب:</th>
                        <th class="text-center">{{$total_quantity}}</th>
                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">المبلغ لإجمالي للشراء:</th>
                        <th class="text-center">{{number_format($total_purchase_price,2)}}</th>
                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">الدين (المبلغ المتبقي):</th>
                        @php
                            /** @var $total_purchase_price */
                            /** @var $purchase */
                            $debt = $total_purchase_price - $purchase->paid_amount;
                        @endphp
                        <th class="text-center text-danger @if($debt != 0) hvr-pop @endif">{{number_format($debt,2)}}</th>
                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">المبلغ الإجمالي للبيع:</th>
                        <th class="text-center">{{number_format($total_sale_price,2)}}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-2">
            <form action="{{Route('deletePurchase',$purchase->id)}}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{Route('editPurchase',$purchase->id)}}"
                   class="btn btn-primary w-25">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                <button type="submit" class="btn btn-danger btn-r w-25"
                        onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash-alt"></i>
                    حــذف
                </button>
                <button class="btn w-25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </form>
        </div>
    </fieldset>
@endsection
