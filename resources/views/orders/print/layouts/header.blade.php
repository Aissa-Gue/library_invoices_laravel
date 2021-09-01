<div class="row justify-content-center text-center mb-4">
    <div class="col-sm-auto mt-4"><!-- 9 -->
        <h5>مؤسسة الشيخ عمي سعيد</h5>
        <h6>ثقافة - تربية - تراث</h6>
    </div>
    <div class="col-sm-3">
        <img class="img-fluid" src="{{asset('img/library_logo.png')}}" width="120px">
    </div>
    <div class="col-sm-auto mt-4"><!-- 9 -->
        <h5>قسم التراث والمكتبة</h5>
        <h6>المكتبة المركزية</h6>
    </div>
</div>

<div class="row text-center mb-4">
    <div class="offset-5 col-sm-3"><!-- 9 -->
        @if($order->type == 'إهداء')
            <h4>إهداء</h4>
        @else
            <h4>فاتورة</h4>
        @endif
    </div>
</div>

<div class="row justify-content-md-center mb-3">
    <div class="col-sm-5">
        <h6 class="mb-3"><strong>رقم الفاتورة: </strong>{{$order->id}}</h6>
        <h6>
            <strong>الزبون: </strong>{{$order->client->last_name . ' ' . $order->client->first_name . ' بن ' . $order->client->father_name}}
        </h6>
    </div>
    <div class="col-sm-5">
        <h6 class="mb-3"><strong>تاريخ الفاتورة: </strong> {{$order->created_at}}</h6>
        <h6><strong>الهاتف: </strong>0{{$order->client->phone1}} / 0{{$order->client->phone2}}</h6>
    </div>
</div>


