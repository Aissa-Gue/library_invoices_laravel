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
                <p><strong>رقم الفاتورة: </strong>{{$order->id}} ~ {{$order->type}}</p>
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
                    <strong>الزبون: </strong>{{$order->client->person->last_name . ' ' . $order->client->person->first_name . ' بن ' . $order->client->person->father_name}}
                </p>
            </div>
            <div class="col-md-4">
                <p><strong>نسبة التخفبض: </strong>{{$order->discount_percentage}}%</p>
            </div>
            <div class="col-md-3">
                <p><strong>المبلغ المدفوع: </strong>{{number_format($order->paid_amount,2)}} دج </p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <p class="text-success fw-bold">
                    <strong class="text-dark me-2">البائع: </strong> <i
                        class="fas fa-user-shield"></i> {{$order->createdBy->username}}
                </p>
            </div>
            <div class="col-md-4">
                <p class="text-success fw-bold">
                    <strong class="text-dark me-2">المعدل: </strong> <i
                        class="fas fa-user-shield"></i> {{$order->updatedBy->username}}
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
                        <td class="text-center">{{number_format($orderBook->purchase_price,2)}}</td>
                        <td class="text-center">{{number_format($orderBook->sale_price,2)}}</td>
                        <td class="text-center">{{$orderBook->quantity}}</td>
                        <td class="text-center">{{number_format($orderBook->purchase_price * $orderBook->quantity,2)}}</td>
                        <td class="text-center">{{number_format($orderBook->sale_price * $orderBook->quantity,2)}}</td>
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
                        <th scope="row" class="text-danger">المبلغ الإجمالي للبيع:</th>
                        <th class="text-center">{{number_format($total_sale_price,2)}}</th>

                    </tr>
                    <tr>
                        <th scope="row" class="text-danger">المبلغ الإجمالي (بالتخفيض):</th>
                        <th class="text-center">{{number_format($total_discountable_price,2)}}</th>
                    </tr>
                    <tr class="">
                        <th scope="row" class="text-danger">الدين (المبلغ المتبقي):</th>
                        @php
                            /** @var $total_discountable_price */
                            /** @var $order */
                            $debt = $total_discountable_price - $order->paid_amount;
                        @endphp
                        <th class="text-center text-danger @if($debt != 0) hvr-pop @endif">{{number_format($debt,2)}}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-2">
            <form action="{{Route('deleteOrder',$order->id)}}" method="post">
                @csrf
                @method('DELETE')
                @if($order->type == 'إهداء')
                    <button type="button" data-bs-toggle="modal" data-bs-target="#giftModal"
                            class="btn btn-success w-25">
                        <i class="fas fa-print"></i>
                        طباعة
                    </button>
                @else
                    <a href="{{Route('printOrder',$order->id)}}"
                       class="btn btn-success w-25">
                        <i class="fas fa-print"></i>
                        طباعة
                    </a>
                @endif
                <a href="{{Route('editOrder',$order->id)}}"
                   class="btn btn-primary w-25">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                @if(Auth::user()->role != 'admin')
                    <button class="btn w-25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                @endif
                @if(Auth::user()->role == 'admin')
                    <button type="submit" class="btn btn-danger btn-r w-25"
                            onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash-alt"></i>
                        حــذف
                    </button>
                @endif
            </form>
        </div>

        <!-- Print Modal -->
        <!-- Modal -->
        <div class="modal fade" id="giftModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="giftModalLabel">نوع الفاتورة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        حدد الفاتورة التي تريد طباعتها؟
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="{{Route('printOrder',$order->id)}}?invoice=buyer" class="btn btn-success">فاتورة
                            الزبون</a>
                        <a href="{{Route('printOrder',$order->id)}}?invoice=seller" class="btn btn-primary">فاتورة
                            البائع</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Print Modal-->
    </fieldset>
@endsection
