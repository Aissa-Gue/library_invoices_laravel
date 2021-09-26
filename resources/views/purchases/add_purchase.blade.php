@extends('layouts.master')

@section('content')
    @include('includes.navbars.orders-purchases.navigation_add')

    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>إضافة فاتورة مزود</h4>
    </div>


    <form action="{{Route('addPurchase')}}" method="post">
        @csrf
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">معلومات الفاتورة</legend>

            <div class="row mb-3">
                <div class="col-md-6">
                    @if(!empty($provider))
                        <label for="client_id" class="form-label">المزود</label>
                        <input type="text" name="provider_id" class="form-control"
                               value="{{$provider->id.' # '.$provider->last_name.' '.$provider->first_name.' بن '.$provider->father_name}}">
                    @else
                        @livewire('provider-search-bar')
                    @endif

                    @error('provider_id')
                    <div class="form-text text-danger">{{$message}}</div>
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
