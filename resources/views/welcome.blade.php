@extends('layouts.master')

@section('content')
    <style>
        .order-card {
            color: #fff;
        }

        .bg-c-blue {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
            background: linear-gradient(45deg, #403fbf, #73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
            background: linear-gradient(45deg, #1c8fa7, #59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg, #FFB64D, #ffcb80);
            background: linear-gradient(45deg, #35444a, #3d9cdd);
        }

        .bg-c-pink {
            background: linear-gradient(45deg, #FF5370, #ff869a);
            background: linear-gradient(45deg, #d10505, #ff869a);
        }


        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 12px;
        }

        .order-card i {
            font-size: 26px;
        }
    </style>

    <div class="row justify-content-md-center">
        <!--Start Card -->
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h5 class="mb-3">الكتب</h5>
                    <h2 class="text-end"><i
                            class="fa fa-book-open float-start"></i><span>{{$total_books->total_books}}</span></h2>
                    <p class="mb-0">السنة الحالية:<span class="float-end">{{$yearly_books->yearly_books}}</span></p>
                </div>
            </div>
        </div>
        <!--Start Card -->
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h5 class="mb-3">الفواتير</h5>
                    <h2 class="text-end"><i
                            class="fa fa-file-invoice float-start"></i><span>{{$total_orders->total_orders}}</span></h2>
                    <p class="mb-0">السنة الحالية:<span class="float-end">{{$yearly_orders->yearly_orders}}</span></p>
                </div>
            </div>
        </div>

        <!--Start Card -->
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h5 class="mb-3">الديون</h5>
                    <h2 class="text-end"><i
                            class="fa fa-money-check float-start"></i><span>{{round($total_debts->total_debts,2)}}</span>
                    </h2>
                    <p class="mb-0">السنة الحالية:<span
                            class="float-end">{{round($yearly_debts->yearly_debts, 2)}}</span></p>
                </div>
            </div>
        </div>

        <!--Start Card -->
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h5 class="mb-3">المداخيل</h5>
                    <h2 class="text-end"><i class="fas fa-euro-sign float-start"></i>
                        @if($total_paid_amounts->total_paid_amounts == null)
                            <span>0.00</span>
                        @else
                            <span>{{round($total_paid_amounts->total_paid_amounts,2)}}</span>
                        @endif
                    </h2>
                    <p class="mb-0">السنة الحالية:<span
                            class="float-end">{{round($yearly_paid_amounts->yearly_paid_amounts,2)}}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- END CARDS row -->




    <div class="row">
        <!-- table 1 -->
        <div class="col-md-7">
            <div class="mx-1 flex-md-fill bd-highlight shadow bg-body rounded p-2">
                <table class="table table-hover caption-top m-0">
                    <caption class="alert alert-danger text-center fw-bold" role="alert">
                        قائمة الديون
                    </caption>
                    <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center">رقم الفاتورة</th>
                        <th scope="col">الزبون</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">المبلغ المتبقي</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($debts as $debt)
                        <tr>
                            <th scope="row" class="text-center">{{$debt->id}}</th>
                            <td>{{$debt->last_name .' '. $debt->first_name .' بن '.$debt->father_name}}</td>
                            <td>{{$debt->created_at->todatestring()}}</td>
                            <td class="text-secondary">
                                @if($debt->debt_amount == null)
                                    <span class="text-danger fw-bold">0.00</span> دج
                                @else
                                    <span class="text-danger fw-bold">{{number_format($debt->debt_amount,2)}}</span> دج
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END table 1 -->

        <!-- table 2 -->
        <div class="col-md-5">
            <div class="mx-1 flex-md-fill bd-highlight shadow bg-body rounded p-2">
                <table class="table table-hover caption-top m-0">
                    <caption class="alert alert-primary text-center fw-bold" role="alert">
                        الكتب القريبة النفاذ
                    </caption>
                    <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">العنوان</th>
                        <th scope="col" class="text-center">الكمية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($alert_books->isEmpty())
                        <th scope="row" colspan="3" class="text-center text-success">لا توجد كتب قريبة النفاذ !</th>
                    @endif
                    @foreach($alert_books as $alert_book)
                        <tr>
                            <th scope="row">{{$alert_book->id}}</th>
                            <td>{{$alert_book->title}}</td>
                            <td class="text-center text-danger fw-bold">{{$alert_book->quantity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END table 1 -->

    </div>

@endsection
