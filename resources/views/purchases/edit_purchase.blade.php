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
                    <input type="text" name="purchase_id" class="form-control text-center" value="{{ $purchase->id }}"
                        id="purchase_id" readonly>
                </div>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text w-25">المزود</span>
                    <input
                        value="{{ $purchase->provider->person->last_name .' ' .$purchase->provider->person->first_name .' بن ' .$purchase->provider->person->father_name }}"
                        class="form-control" name="provider_id" id="provider_id" placeholder="أدخل اسم المزود" disabled>
                </div>
            </div>
        </div>
    </fieldset>


    <fieldset class="scheduler-border">
        <legend class="scheduler-border">قائمة الكتب</legend>

        <form action="{{ Route('editPurchase', $purchase->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row justify-content-md-center mb-4">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">المبلغ المدفوع (دج) </span>
                        <input type="text" class="form-control text-center" value="{{ $purchase->paid_amount }}"
                            name="paid_amount" id="paid_amount">

                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </div>
                    @error('paid_amount')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>

        @if (session()->has('paidAmountAlert'))
            <div class="alert alert-danger alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                <i class="fas fa-times-circle me-2 fs-5"></i>
                <div>
                    {{ session()->get('paidAmountAlert') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('percentageAlert'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div>
                    {{ session()->get('percentageAlert') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('purchasePriceAlert'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div>
                    {{ session()->get('purchasePriceAlert') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('priceAlert'))
            <script>
                $(document).ready(function() {
                    $('#msgModal').modal("show");
                });
            </script>

            <!-- Modal -->
            <div class="modal fade" id="msgModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">انتبه</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center text-danger">
                            <i class="fas fa-exclamation-triangle fs-1 mb-4 hvr-pop"></i>
                            <h5>{{ session()->get('priceAlert') }}</h5>
                            <h5 class="mb-3">هل تريد تغيير نسبة البيع ؟</h5>
                            <div class="row">
                                <h6 class="text-dark text-start fw-bold col-md-12 mb-3"># عنوان الكتاب: <span
                                        class="text-success fw-bolder">{{ session()->get('title') }}</span>
                                </h6>
                                <h6 class="text-dark text-start fw-bold col-md-4"># نسبة البيع القديمة:
                                    <span class="text-danger fw-bolder">{{ session()->get('oldSalePercentage') }} %</span>
                                </h6>
                                <h6 class="text-dark text-start fw-bold col-md-4"># سعر الشراء القديم:
                                    <span class="text-danger fw-bolder">{{ session()->get('oldPurchasePrice') }} دج </span>
                                </h6>
                                <h6 class="text-dark text-start fw-bold col-md-4"># سعر البيع القديم:
                                    <span class="text-danger fw-bolder">{{ session()->get('oldSalePrice') }} دج </span>
                                </h6>
                            </div>
                            <div class="row justify-content-center mt-4">
                                <div class="col-md-6">
                                    <form action="{{ Route('editSalePercentage', session()->get('bookId')) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <span class="input-group-text">تغيير نسبة البيع</span>
                                            <select class="form-control text-center" name="sale_percentage" required>
                                                <option>- اختر نسبة مئوية -</option>
                                                <option value="0">0%</option>
                                                <option value="10">10%</option>
                                                <option value="15">15%</option>
                                                <option value="20">20%</option>
                                                <option value="25">25%</option>
                                                <option value="30">30%</option>
                                            </select>
                                            <button type="submit" class="btn btn-outline-success">تغيير</button>
                                        </div>
                                        @error('sale_percentage')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ Route('purchasePriceAlert', $purchase->id) }}" class="btn btn-outline-danger">لا،
                                شكرا
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MODAL -->
        @endif

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
                <label for="purchase_price_sum">المجموع</label>
            </div>
        </div>
        @foreach ($purchaseBooks as $purchaseBook)
            <div class="row mt-1">
                <div class="col-md-5">
                    <input value="{{ $purchaseBook->book->title }}" class="form-control" id="title" disabled>
                </div>

                <div class="col-md-2">
                    <input type="number" class="form-control text-center" id="quantity"
                        value="{{ $purchaseBook->quantity }}" disabled>
                </div>

                <div class="col-md-2">
                    <input type="text" class="form-control text-center" id="purchase_price"
                        value="{{ number_format($purchaseBook->purchase_price, 2) }}" disabled>
                </div>

                <div class="col-md-2">
                    <input type="text" class="form-control text-center" id="purchase_price_sum"
                        value="{{ number_format($purchaseBook->purchase_price * $purchaseBook->quantity, 2) }}" disabled>
                </div>

                <div class="col-md-1">
                    <form action="{{ Route('deletePurchaseBook', [$purchase->id, $purchaseBook->book_id]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('هل أنت متأكد؟')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- insert book -->
        <form action="{{ Route('addPurchaseBook', $purchase->id) }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="form-group col-md-5">
                    @livewire('book-search-bar',['purchase_id' => $purchase->id])
                    @error('book_id')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <input type="number" class="form-control text-center" name="quantity" id="quantity" required>
                    @error('quantity')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <input type="number" class="form-control text-center" name="purchase_price" id="purchase_price"
                        required>
                    @error('purchase_price')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z" />
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
                            <th class="text-center">{{ $total_quantity }}</th>
                        </tr>
                        <tr>
                            <th scope="row" class="text-danger">المبلغ لإجمالي للشراء:</th>
                            <th class="text-center">{{ number_format($total_purchase_price, 2) }}</th>
                        </tr>
                        <tr>
                            <th scope="row" class="text-danger">المبلغ الإجمالي للبيع:</th>
                            <th class="text-center">{{ number_format($total_sale_price, 2) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-4">
            <form action="{{ Route('deletePurchase', $purchase->id) }}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ Route('previewPurchase', $purchase->id) }}" class="btn btn-success px-3 py-2">
                    <i class="fas fa-eye"></i><br>
                    عرض
                </a>
                <button type="submit" class="btn btn-danger px-3 py-2" onclick="return confirm('هل أنت متأكد؟')">
                    <i class="fas fa-trash-alt"></i><br>
                    حـذف
                </button>
            </form>
        </div>
    </fieldset>
@endsection
