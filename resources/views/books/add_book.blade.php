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
                        <div class="col-md-3 mb-2">
                            <label class="form-label" for="book_id">رقم الكتاب</label>
                            <input type="number" class="form-control text-center" name="book_id" id="book_id"
                                   placeholder="أدخل رقم الكتاب" value="{{request()->get('book_id')}}" readonly>
                        </div>
                        <div class="col-md-9 mb-2">
                            <label class="form-label" for="title">عنوان الكتاب</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="أدخل عنوان الكتاب" value="{{request()->get('title')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('title') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="author">المؤلف</label>
                            <input type="text" class="form-control" name="author" id="author"
                                   placeholder="أدخل المؤلف" value="{{request()->get('author')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('author') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="investigator">المحقق</label>
                            <input type="text" class="form-control" name="investigator" id="investigator"
                                   placeholder="أدخل المحقق" value="{{request()->get('investigator')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('investigator') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-7 mb-2">
                            <label class="form-label" for="translator">المترجم</label>
                            <input type="text" class="form-control" name="translator" id="translator"
                                   placeholder="أدخل المترجم" value="{{request()->get('translator')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('translator') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="publisher">الناشر</label>
                            <input type="text" class="form-control" name="publisher" id="publisher"
                                   placeholder="أدخل الناشر" value="{{request()->get('publisher')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('publisher') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="publication_year">سنة النشر</label>
                            <input type="number" class="form-control" name="publication_year" id="publication_year"
                                   placeholder="أدخل سنة النشر" value="{{request()->get('publication_year')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('publication_year') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="edition">الطبعة</label>
                            <input type="text" class="form-control" name="edition" id="edition"
                                   placeholder="أدخل الطبعة" value="{{request()->get('edition')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('edition') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="quantity">الكمية</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                   placeholder="أدخل عدد الكتب" value="{{request()->get('quantity')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('quantity') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="discount">إمكانية التخفيض</label>
                            <select name="discount" id="discount" class="form-control">
                                <option value="1" @if(request()->get('discount') == 1) {{'selected'}} @endif>نعم
                                </option>
                                <option value="0" @if(request()->get('discount') == 0) {{'selected'}} @endif>لا</option>
                            </select>
                            @if(!empty($messages))
                                @foreach ($messages->get('discount') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="purchase_price">سعر الشراء</label>
                            <input type="number" class="form-control" name="purchase_price" id="purchase_price"
                                   placeholder="أدخل سعر الشراء" value="{{request()->get('purchase_price')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('purchase_price') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="sale_price">سعر البيع</label>
                            <input type="number" class="form-control" name="sale_price" id="sale_price"
                                   placeholder="أدخل سعر البيع" value="{{request()->get('sale_price')}}">
                            @if(!empty($messages))
                                @foreach ($messages->get('sale_price') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
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
