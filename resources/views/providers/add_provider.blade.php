@extends('layouts.master')

@section('content')
    @include('includes.navbars.clients-providers.navigation_add')

    <div class="alert alert-primary text-center mb-4" role="alert">
        <h4>إضافة مزود</h4>
    </div>
    <form action="{{Route('addProvider')}}" method="post">
        @csrf
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">معلومات المزود</legend>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="form-label" for="last_name">اللقب</label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                           placeholder="أدخل لقب المزود" value="{{old('last_name')}}">
                    @error('last_name')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-2">
                    <label class="form-label" for="first_name">الاسم</label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                           placeholder="أدخل اسم المزود" value="{{old('first_name')}}">
                    @error('first_name')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label" for="father_name">اسم الأب</label>
                    <input type="text" class="form-control" name="father_name" id="father_name"
                           placeholder="أدخل اسم الأب" value="{{old('father_name')}}">
                    @error('father_name')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label class="form-label" for="establishment">المؤسسة</label>
                    <input type="text" class="form-control" name="establishment"
                           id="establishment"
                           placeholder="أدخل اسم المؤسسة" value="{{old('establishment')}}">
                    @error('establishment')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="address">العنوان</label>
                    <input type="text" class="form-control" name="address" id="address"
                           placeholder="أدخل عنوان المزود" value="{{old('address')}}">
                    @error('address')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <label class="form-label" for="phone1">رقم الهاتف 1</label>
                    <input type="text" pattern="(05|06|07)\d{8}" maxlength="10" class="form-control" name="phone1"
                           id="phone1"
                           placeholder="أدخل رقم هاتف المزود" value="{{old('phone1')}}">
                    @error('phone1')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="phone2">رقم الهاتف 2</label>
                    <input type="text" pattern="(05|06|07)\d{8}" maxlength="10" class="form-control" name="phone2"
                           id="phone2"
                           placeholder="أدخل رقم هاتف المزود" value="{{old('phone2')}}">
                    @error('phone2')
                    <div class="form-text text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-outline-success py-2"><i class="fas fa-plus"></i> إضافة المزود
                </button>
            </div>
        </fieldset>
    </form>

@stop
