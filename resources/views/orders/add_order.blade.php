@extends('layouts.master')

@section('content')
    @if (Auth::user()->role == 'admin')
        @include('includes.navbars.orders-purchases.navigation_add')
    @endif

    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>إضافة فاتورة زبون</h4>
    </div>


    <form action="{{ Route('addOrder') }}" method="post">
        @csrf
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">معلومات الفاتورة</legend>
            <!-- 1st row -->
            <div class="row mb-3">
                <div class="form-group col-md-2">
                    <label for="type" class="form-label">نوع الفاتورة</label>
                    <select class="form-select" name="type" id="type">
                        <option value="بيع">بيع</option>
                        <option value="معرض">معرض</option>
                        @if (Auth::user()->role == 'admin')
                            <option value="إهداء">إهداء</option>
                        @endif
                    </select>
                    @error('type')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    @if (!empty($client))
                        <label for="client_id" class="form-label">الزبون</label>
                        <input type="text" name="client_id" class="form-control"
                            value="{{ $client->id . ' # ' . $client->last_name . ' ' . $client->first_name . ' بن ' . $client->father_name }}">
                    @else
                        @livewire('client-search-bar')
                    @endif

                    @error('client_id')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-2">
                    <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
                    <input type="text" class="form-control" name="discount_percentage" value="0" id="discount_percentage">
                    @error('discount_percentage')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-outline-success py-2"><i class="fas fa-plus"></i> إضافة
                    الفاتورة
                </button>
            </div>
        </fieldset>
    </form>
@endsection
