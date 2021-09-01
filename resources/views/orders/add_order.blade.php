@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>إضافة فاتورة</h4>
    </div>

    <form action="{{Route('addOrder')}}" method="post">
        @csrf
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">معلومات الفاتورة</legend>
            <!-- 1st row -->
            <div class="row mb-3">
                <div class="col-md-2 ">
                    <label for="order_id" class="form-label">رقم الفاتورة</label>
                    <input type="number" name="order_id" class="form-control text-center"
                           value="" id="order_id" readonly>
                </div>

                <div class="form-group col-md-2">
                    <label for="type" class="form-label">نوع الفاتورة</label>
                    <select class="form-control" name="type" id="type">
                        <option value="بيع">بيع</option>
                        <option value="معرض">معرض</option>
                        <option value="إهداء">إهداء</option>
                    </select>
                    @error('type')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    @livewire('client-search-bar')
                    @error('client_id')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
                    <input type="text" class="form-control" name="discount_percentage" id="discount_percentage">
                    @error('discount_percentage')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-outline-success py-2"><i class="fas fa-plus"></i> إضافة الفاتورة
                </button>
            </div>
        </fieldset>
    </form>
@endsection
