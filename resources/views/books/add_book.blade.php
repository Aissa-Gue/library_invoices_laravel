@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>إضافة كتاب</h4>
    </div>

    <form action="{{Route('addBook')}}" method="post">
        @csrf
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">معلومات الكتاب</legend>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-10 mb-2">
                            <label class="form-label" for="title">عنوان الكتاب</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="أدخل عنوان الكتاب" value="{{old('title')}}">
                            @error('title')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="author">المؤلف</label>
                            <input type="text" class="form-control" name="author" id="author"
                                   placeholder="أدخل المؤلف" value="{{old('author')}}">
                            @error('author')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="investigator">المحقق</label>
                            <input type="text" class="form-control" name="investigator" id="investigator"
                                   placeholder="أدخل المحقق" value="{{old('investigator')}}">
                            @error('investigator')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="translator">المترجم</label>
                            <input type="text" class="form-control" name="translator" id="translator"
                                   placeholder="أدخل المترجم" value="{{old('translator')}}">
                            @error('translator')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="publisher">الناشر</label>
                            <input type="text" class="form-control" name="publisher" id="publisher"
                                   placeholder="أدخل الناشر" value="{{old('publisher')}}">
                            @error('publisher')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="publication_year">سنة النشر</label>
                            <input type="number" class="form-control" name="publication_year" id="publication_year"
                                   placeholder="أدخل سنة النشر" value="{{old('publication_year')}}">
                            @error('publication_year')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="edition">الطبعة</label>
                            <input type="text" class="form-control" name="edition" id="edition"
                                   placeholder="أدخل الطبعة" value="{{old('edition')}}">
                            @error('edition')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="quantity">الكمية</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                   placeholder="أدخل عدد الكتب" value="{{old('quantity')}}">
                            @error('quantity')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="discount">إمكانية التخفيض</label>
                            <select name="discount" id="discount" class="form-control">
                                <option value="1" @if(old('discount') == 1) {{'selected'}} @endif>نعم
                                </option>
                                <option value="0" @if(old('discount') == 0) {{'selected'}} @endif>لا</option>
                            </select>
                            @error('discount')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="purchase_price">سعر الشراء</label>
                            <input type="number" class="form-control" name="purchase_price" id="purchase_price"
                                   placeholder="أدخل سعر الشراء" value="{{old('purchase_price')}}">
                            @error('purchase_price')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="sale_percentage">نسبة البيع</label>
                            <select class="form-control text-center" id="sale_percentage" name="sale_percentage" value="{{old('sale_percentage')}}" required>
                                <option>- اختر نسبة مئوية -</option>
                                <option value="0">0%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                            </select>
                            @error('sale_percentage')
                            <div class="form-text text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success py-2"><i class="fas fa-plus"></i> إضافة الكتاب
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
@endsection
