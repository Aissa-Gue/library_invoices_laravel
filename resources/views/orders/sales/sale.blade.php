@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>بيع بالتجزئة</h4>
    </div>

    <form action="{{Route('addSale')}}" method="get">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">تفاصيل البيع</legend>
            <!-- 1st row -->

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="quantity" class="form-label mt-2"> عنوان الكتاب</label>
                    <div class="input-group">
                        <div class="col-md-5">
                            @livewire('book-search-bar',['order_id' => 0])
                        </div>
                        <div class="col-md-2">
                            <input type="text" pattern="[0-9]*" maxlength="2" class="form-control" name="quantity"
                                   id="quantity" placeholder="الكمية" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-success">عرض</button>
                        </div>
                    </div>
                </div>
                @error('book_id')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
                @error('quantity')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
    </form>

    @if(!empty($book_data))
        <table class="table">
            <thead>
            <tr class="text-secondary">
                <th scope="col">عنوان الكتاب</th>
                <th scope="col" class="text-center">الكمية</th>
                <th scope="col" class="text-center">سعر الوحدة</th>
                <th scope="col" class="text-center">السعر الإجمالي</th>
                <th scope="col" class="text-center">تأكيد البيع</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="fw-bold">{{$book_data['title']}}</td>
                <td class="fw-bold text-center">{{$book_data['quantity']}}</td>
                <td class="text-center fw-bold">{{number_format($book_data['salePrice'],2)}} دج</td>
                <td class="text-danger fw-bold text-center">{{number_format($book_data['totalSalePrice'],2)}} دج</td>
                <td class="text-center">
                    <button type="submit" onclick="event.preventDefault();
                        document.getElementById('saleForm').submit();"
                            class="btn btn-success rounded-pill px-4"><i class="fas fa-shopping-cart"></i> بيع
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="text-end">
            <form id="saleForm" action="{{Route('updateStock')}}" method="post">
                @csrf
                <input type="hidden" name="book_id" value="{{$book_data['book_id']}}">
                <input type="hidden" name="quantity" value="{{$book_data['quantity']}}">
            </form>
        </div>
    @endif


    @if(!empty($message))
        <div class="alert alert-success alert-dismissible fade show fw-bold d-flex align-items-center mt-4" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16" role="img">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div>
                {{$message}}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        </fieldset>

@endsection
