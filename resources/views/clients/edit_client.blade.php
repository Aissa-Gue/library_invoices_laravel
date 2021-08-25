@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center" role="alert">
        <h4>تعديل معلومات الزبون</h4>
    </div>
    <form action="{{Route('editClient',$client->id)}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-2 mb-3">
                <label class="form-label" for="client_id">رقم الزبون</label>
                <input type="number" class="form-control text-center" name="client_id" id="client_id"
                       value="{{$client->id}}" placeholder="أدخل رقم الزبون">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="last_name">اللقب</label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                       placeholder="أدخل لقب الزبون" value="{{old('last_name') ?? $client->last_name}}">
                @error('last_name')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label" for="first_name">الاسم</label>
                <input type="text" class="form-control" name="first_name" id="first_name"
                       placeholder="أدخل اسم الزبون" value="{{old('first_name') ?? $client->first_name}}">
                @error('first_name')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label" for="father_name">اسم الأب</label>
                <input type="text" class="form-control" name="father_name" id="father_name"
                       placeholder="أدخل اسم الأب" value="{{old('father_name') ?? $client->father_name}}">
                @error('father_name')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="phone1">رقم الهاتف 1</label>
                <input type="text" pattern="\d*" maxlength="10" class="form-control" name="phone1" id="phone1"
                       placeholder="أدخل رقم هاتف الزبون" value="{{old('phone1') ?? 0 . $client->phone1}}">
                @error('phone1')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>


        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="phone2">رقم الهاتف 2</label>
                <input type="text" pattern="\d*" maxlength="10" class="form-control" name="phone2" id="phone2"
                       placeholder="أدخل رقم هاتف الزبون" value="{{old('phone2') ?? 0 . $client->phone2}}">
                @error('phone2')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 mb-3">
                <label class="form-label" for="address">العنوان</label>
                <input type="text" class="form-control" name="address" id="address"
                       placeholder="أدخل عنوان الزبون" value="{{old('address') ?? $client->address}}">
                @error('address')
                <div class="form-text text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="float-end mb-3">
            <button type="submit" class="btn btn-success btn-lg">تعديل</button>
        </div>
    </form>

@stop
