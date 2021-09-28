<fieldset class="scheduler-border">
    <legend class="scheduler-border">الكتب المباعة</legend>

    <div class="row justify-content-sm-center mb-3">
        <div class="col-sm-7">
            <form action="{{Route('addSale')}}" method="get">
                <div class="input-group mb-3">
                    <span class="input-group-text">العنوان</span>
                    <input type="text" name="title" class="form-control"
                           placeholder="أدخل عنوان الكتاب" value="{{request('title')}}">

                    <span class="input-group-text">التاريخ</span>
                    <input type="date" name="created_at" class="form-control"
                           placeholder="أدخل تاريخ البيع" value="{{request('created_at') ?? date('Y-m-d')}}">
                    <button class="btn btn-primary" type="submit">بحث</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 1st row -->
    <table class="table table-hover">
        <thead>
        <tr class="text-secondary">
            <th scope="col">#</th>
            <th scope="col">عنوان الكتاب</th>
            <th scope="col" class="text-center">التاريخ</th>
            <th scope="col" class="text-center">البائع</th>
            <th scope="col" class="text-center">الكمية</th>
            <th scope="col" class="text-center">السعر الإجمالي</th>
            <th scope="col" class="text-center">إرجاع</th>
        </tr>
        </thead>
        <tbody>
        @if($sales->isEmpty())
            <tr class="fw-bold text-center text-danger">
                <td colspan="7" class="py-4"><i class="fas fa-exclamation-triangle fs-4 mb-3"></i><br>  لا توجد مبيعات !</td>
            </tr>
        @endif
        @foreach($sales as $sale)
            <tr>
                <td class="fw-bold">{{$sale->id}}</td>
                <td class="fw-bold">{{$sale->title}}</td>
                <td class="fw-bold text-center">{{$sale->created_at->todatestring()}}</td>
                <td class="fw-bold text-center text-success"><i class="fas fa-user-shield"></i> {{$sale->createdBy->username}}</td>
                <td class="fw-bold text-center">{{$sale->quantity}}</td>
                <td class="text-success fw-bold text-center">{{number_format($sale->sale_price * $sale->quantity,2)}}
                    دج
                </td>
                <td class="text-center">
                    <form id="deleteSale" action="{{Route('deleteSale',$sale->id)}}" method="post">
                        @csrf
                        <button type="submit" onclick="return confirm('هل أنت متأكد؟')"
                                class="btn btn-outline-danger rounded-pill px-4"><i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row justify-content-center fixed-bottom">
        <div class="offset-2 col-md-auto">
            {{$sales->links()}}
        </div>
    </div>
</fieldset>

