@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center h4" role="alert">
        معلومات الفاتورة
    </div>

    <!-- 1st row -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">معلومات الفاتورة</legend>
        <div class="row mt-3">
            <div class="col-md-4">
                <p><strong>رقم الفاتورة: </strong>{{$order->id}}</p>
            </div>
            <div class="col-md-4">
                <p><strong>تاريخ الفاتورة: </strong>{{$order->created_at}}</p>
            </div>
            <div class="col-md-4">
                <p><strong>تاريخ آخر تعديل: </strong>{{$order->updated_at}}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <p>
                    <strong>الزبون: </strong>{{$order->client->last_name . ' ' . $order->client->first_name . ' بن ' . $order->client->father_name}}
                </p>
            </div>
            <div class="col-md-4">
                <p><strong>نسبة التخفبض: </strong>{{$order->discount_percentage}}%</p>
            </div>
            <div class="col-md-3">
                <p><strong>المبلغ المدفوع: </strong>{{$order->paid_amount}} دج </p>
            </div>
        </div>
    </fieldset>

    <!-- 3rd row -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">فائمة الكتب</legend>
        <div class="row mt-3">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان الكتاب</th>
                    <th scope="col" class="text-center">سعر الشراء</th>
                    <th scope="col" class="text-center">سعر البيع</th>
                    <th scope="col" class="text-center">الكمية</th>
                    <th scope="col" class="text-center">إجمالي الشراء</th>
                    <th scope="col" class="text-center">إجمالي البيع</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 0 @endphp
                @foreach($orderBooks as $orderBook)
                    <tr>
                        <th scope="row">{{++$i}}</th>
                        <td>{{$orderBook->book->title}}</td>
                        <td class="text-center">{{$orderBook->purchase_price}}.00</td>
                        <td class="text-center">{{$orderBook->sale_price}}.00</td>
                        <td class="text-center">{{$orderBook->quantity}}</td>
                        <td class="text-center">{{$orderBook->purchase_price * $orderBook->quantity}}.00</td>
                        <td class="text-center">{{$orderBook->sale_price * $orderBook->quantity}}.00</td>
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
                        <th class="text-center">{{$total_purchase_price}}.00</th>
                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">المبلغ الإجمالي للبيع:</th>
                        <th class="text-center">{{$total_sale_price}}.00</th>

                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">المبلغ الإجمالي (بالتخفيض):</th>
                        <th class="text-center">{{$total_discountable_price}}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-2">
            <form action="{{Route('deleteOrder',$order->id)}}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{Route('previewOrder',$order->id)}}" class="btn btn-success w-25">
                    <i class="fas fa-print"></i>
                    طباعة
                </a>
                <a href="{{Route('editOrder',$order->id)}}" class="btn btn-primary w-25">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                <button type="submit" class="btn btn-danger btn-r"
                        onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash-alt w-25"></i>
                    حــذف
                </button>
            </form>
        </div>
    </fieldset>
@endsection
