<link href="{{ URL::asset('css/cards.css') }}" rel="stylesheet">

<div class="row justify-content-md-center">
    <!--Start Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card bg-c-blue order-card">
            <div class="card-block">
                <h5 class="mb-3">الكتب</h5>
                <h2 class="text-end"><i
                        class="fa fa-book-open float-start"></i><span>{{ $monthly_books->monthly_books }}</span></h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{ $yearly_books->yearly_books }}</span></p>
            </div>
        </div>
    </div>
    <!--Start Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card bg-c-green order-card">
            <div class="card-block">
                <h5 class="mb-3">الفواتير</h5>
                <h2 class="text-end"><i
                        class="fa fa-file-invoice float-start"></i><span>{{ $monthly_orders->monthly_orders }}</span>
                </h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{ $yearly_orders->yearly_orders }}</span></p>
            </div>
        </div>
    </div>

    <!--Start Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card bg-c-pink order-card">
            <div class="card-block">
                <h5 class="mb-3">الديون</h5>
                <h2 class="text-end"><i
                        class="fa fa-money-check float-start"></i><span>{{ number_format($monthly_debts->monthly_debts, 2) }}</span>
                </h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{ number_format($yearly_debts->yearly_debts, 2) }}</span></p>
            </div>
        </div>
    </div>

    <!--Start Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card bg-c-yellow order-card">
            <div class="card-block">
                <h5 class="mb-3">المداخيل</h5>
                <h2 class="text-end"><i class="fas fa-euro-sign float-start"></i>
                    <span>{{ number_format($monthly_paid_amounts->monthly_paid_amounts + $monthly_sales->monthly_sales, 2) }}</span>
                </h2>
                <p class="mb-0">السنة الحالية:<span
                        class="float-end">{{ number_format($yearly_paid_amounts->yearly_paid_amounts + $yearly_sales->yearly_sales, 2) }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END CARDS row -->
