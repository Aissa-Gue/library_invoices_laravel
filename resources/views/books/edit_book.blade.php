@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center" role="alert">
        <h4>تعديل معلومات الكتاب</h4>
    </div>

    <form action="{{Route('editBook',$book->id)}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-2 mb-3">
                <label class="form-label" for="book_id">رقم الكتاب</label>
                <input type="number" class="form-control text-center" name="book_id" id="book_id"
                       placeholder="أدخل رقم الكتاب" value="{{$book->id}}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="title">عنوان الكتاب</label>
                <input type="text" class="form-control" name="title" id="title"
                       placeholder="أدخل عنوان الكتاب" value="{{old('title') ?? $book->title}}">
                @error('title')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="author">المؤلف</label>
                <input type="text" class="form-control" name="author" id="author"
                       placeholder="أدخل المؤلف" value="{{old('author') ?? $book->author}}">
                @error('author')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label" for="investigator">المحقق</label>
                <input type="text" class="form-control" name="investigator" id="investigator"
                       placeholder="أدخل المحقق" value="{{old('investigator') ?? $book->investigator}}">
                @error('investigator')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label" for="translator">المترجم</label>
                <input type="text" class="form-control" name="translator" id="translator"
                       placeholder="أدخل المترجم" value="{{old('translator') ?? $book->translator}}">
                @error('translator')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="publisher">الناشر</label>
                <input type="text" class="form-control" name="publisher" id="publisher"
                       placeholder="أدخل الناشر" value="{{old('publisher') ?? $book->publisher}}">
                @error('publisher')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label" for="publication_year">سنة النشر</label>
                <input type="number" class="form-control" name="publication_year" id="publication_year"
                       placeholder="أدخل سنة النشر" value="{{old('publication_year') ?? $book->publication_year}}">
                @error('publication_year')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label" for="edition">الطبعة</label>
                <input type="text" class="form-control" name="edition" id="edition"
                       placeholder="أدخل الطبعة" value="{{old('edition') ?? $book->edition}}">
                @error('edition')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-3">
                <label class="form-label" for="purchase_price">سعر الشراء</label>
                <input type="number" class="form-control" name="purchase_price" id="purchase_price"
                       placeholder="أدخل سعر الشراء" value="{{old('purchase_price') ?? $book->purchase_price}}">
                @error('purchase_price')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label" for="sale_price">سعر البيع</label>
                <input type="number" class="form-control" name="sale_price" id="sale_price"
                       placeholder="أدخل سعر البيع" value="{{old('sale_price') ?? $book->sale_price}}">
                @error('sale_price')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label" for="quantity">الكمية</label>
                <input type="number" class="form-control" name="quantity" id="quantity"
                       placeholder="أدخل عدد الكتب" value="{{old('quantity') ?? $book->quantity}}">
                @error('quantity')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-3">
                <label class="form-label" for="discount">إمكانية التخفيض</label>
                <select name="discount" id="discount" class="form-control">
                    <option value="1" @if($book->discount == 1) {{'selected'}} @endif>نعم</option>
                    <option value="0" @if($book->discount == 0) {{'selected'}} @endif>لا</option>
                </select>
                @error('discount')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="float-end mb-3">
            <button type="submit" class="btn btn-success btn-lg">تعديل
            </button>
        </div>
    </form>

@stop
