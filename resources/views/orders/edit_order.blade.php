@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center" role="alert">
        <h4>تفاصيل الفاتورة</h4>
    </div>

    <fieldset class="scheduler-border">
        <legend class="scheduler-border">معلومات الفاتورة</legend>

        <!-- 1st row -->
        <div class="row my-3">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">رقم الفاتورة</span>
                    <input type="text" name="order_id" class="form-control text-center"
                           value="{{$order->id}} ~ {{$order->type}}" id="order_id" readonly>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text w-25">الزبون</span>
                    <input value="{{$order->client->person->last_name.' '.$order->client->person->first_name.' بن '.$order->client->person->father_name}}" class="form-control" name="client_id" id="client_id"
                           placeholder="أدخل اسم الزبون" disabled>
                </div>
            </div>
        </div>
    </fieldset>



    <fieldset class="scheduler-border">
        <legend class="scheduler-border">قائمة الكتب</legend>

        <form action="{{Route('editOrder',$order->id)}}" method="post">
            @csrf
            <div class="row justify-content-md-center mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">نسبة التخفيض (%)</span>
                        <input type="text" class="form-control text-center" value="{{$order->discount_percentage}}"
                               name="discount_percentage" id="discount_percentage">

                        <span class="input-group-text">المبلغ المدفوع (دج) </span>
                        <input type="text" class="form-control text-center" value="{{$order->paid_amount}}"
                               name="paid_amount" id="paid_amount">

                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </div>
                    @error('discount_percentage')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                    @error('paid_amount')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            @if(session()->has('paidAmountAlert'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                    <i class="fas fa-times-circle me-2 fs-5"></i>
                    <div>
                        {{session()->get('paidAmountAlert')}}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </form>

        <div class="row mt-3">
            <div class="col-md-5">
                <label for="title" class="form-label">عنوان الكتاب</label>
            </div>

            <div class="col-md-2 text-center">
                <label for="quantity">الكمية</label>
            </div>

            <div class="col-md-2 text-center">
                <label for="purchase_price">سعر الشراء</label>
            </div>

            <div class="col-md-2 text-center">
                <label for="sale_price">سعر البيع</label>
            </div>

        </div>

        @foreach($orderBooks as $orderBook)
            <div class="row mt-1">
                <div class="col-md-5">
                    <input value="{{$orderBook->book->title}}" class="form-control" id="title"
                           disabled>
                </div>

                <div class="col-md-2">
                    <input type="number" class="form-control text-center" id="quantity"
                           value="{{$orderBook->quantity}}" disabled>
                </div>

                <div class="col-md-2">
                    <input type="text" class="form-control text-center" id="purchase_price"
                           value="{{number_format($orderBook->purchase_price * $orderBook->quantity,2)}}" disabled>
                </div>

                <div class="col-md-2">
                    <input type="text" class="form-control text-center" id="sale_price"
                           value="{{number_format($orderBook->sale_price * $orderBook->quantity,2)}}" disabled>
                </div>

                <div class="col-md-1">
                    <form action="{{Route('deleteOrderBook',array($order->id,$orderBook->book_id))}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('هل أنت متأكد؟')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
    @endforeach

    <!-- insert book -->
        <form action="{{Route('addOrderBook',$order->id)}}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="form-group col-md-5">
                    @livewire('book-search-bar',['order_id' => $order->id])
                    @error('book_id')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <input type="number" class="form-control text-center" name="quantity" id="quantity"
                           required>
                    @error('quantity')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-success" name="insertOrderBook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
        <!-- END insert book -->

            <!-- END 3rd row -->
        <div class="row justify-content-md-end mt-4">
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
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-4">
            <form action="{{Route('deleteOrder',$order->id)}}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{Route('previewOrder',$order->id)}}" class="btn btn-success px-3 py-2">
                    <i class="fas fa-eye"></i><br>
                    عرض
                </a>
                <button type="submit" class="btn btn-danger px-3 py-2"
                        onclick="return confirm('هل أنت متأكد؟')">
                    <i class="fas fa-trash-alt"></i><br>
                    حـذف
                </button>
            </form>
        </div>
    </fieldset>
@endsection
