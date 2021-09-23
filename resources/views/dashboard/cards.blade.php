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
                        class="fa fa-money-check float-start"></i><span>{{number_format($total_debts->total_debts,2)}}</span>
                </h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{number_format($yearly_debts->yearly_debts, 2)}}</span></p>
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
                        <span>{{number_format($total_paid_amounts->total_paid_amounts,2)}}</span>
                    @endif
                </h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{number_format($yearly_paid_amounts->yearly_paid_amounts,2)}}</span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END CARDS row -->

