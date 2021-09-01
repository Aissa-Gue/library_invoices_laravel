@extends('orders.print.layouts.master')
@section('content')
    <div class="justify-content-center">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">العنوان</th>
                <th class="text-center">المؤلف</th>
                <th class="text-center" width="60px">الكمية</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 0; @endphp
            @foreach($orderBooks as $orderBook)
                <tr>
                    <th scope="row" class="text-center">{{++$i}}</th>
                    <td class="">{{$orderBook->book->title}}</td>
                    <td class="">{{$orderBook->book->author}}</td>
                    <td class="text-center" width="60px">{{$orderBook->quantity}}</td>
                </tr>

                @php
                    //Number of pages
                        if(($orderBooks->count() -22) % 32 == 0){
                            $pages = round($orderBooks->count() / 32);
                        }else{
                            $pages = round($orderBooks->count() / 32) +1;
                        }
                    //current page nbr
                        if($i == 22){
                            $page = 1;
                        }elseif(($i - 22) % 32 == 0){
                            $page++;
                        }
                @endphp

                @if($i == 22 or ($i - 22) % 32 == 0)
                    <tr style="border-color: #ffffff">
                        <td colspan="4" class="text-center pt-3">
                            {{'| الصفحة '. $page.' / '.$pages.' | '}}
                            <br>
                            <br>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <div class="row justify-content-end total">
            <table class="col-sm-5 table">
                <tbody>
                <tr>
                    <th colspan="3"></th>
                    <th scope="row" class="text-center">عدد الكتب:</th>
                    <td class="text-center fs-5">{{$total_quantity}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
