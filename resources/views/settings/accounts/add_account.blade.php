@extends('layouts.master')

@section('content')
    @include('includes.navbars.settings.navigation')

    <div class="row mt-3">
        <!-------- CREATE ACCOUNT SECTION ---------->
        <div class="col-md-6">
            <h4><i class="fas fa-user-plus"></i> إضافة حساب جديد</h4>
            <hr class="mb-4">

            <form method="post" action="{{Route('createAccount')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-4">كلمة مرور المسؤول</label>
                        <div class="col-md-8">
                            <input type="password" name="admin_password" class="form-control"
                                   placeholder="أدخل كلمة مرور المسؤول" required/>
                            @if(!empty($messages))
                                @foreach ($messages->get('admin_password') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-4">اسم المستخدم</label>
                        <div class="col-md-8">
                            <input type="text" name="username" class="form-control"
                                   placeholder="أدخل اسم المستخدم" required/>
                            @if(!empty($messages))
                                @foreach ($messages->get('username') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-4">صلاحيات المستخدم</label>
                        <div class="col-md-8">
                            <select id="role" class="form-control @error('role') is-invalid @enderror" name="role"
                                    required>
                                <option value="seller" @if(old('role') == 'seller') selected @endif>بائع</option>
                                <option value="admin" @if(old('role') == 'admin') selected @endif>مسؤول</option>
                            </select>
                            @if(!empty($messages))
                                @foreach ($messages->get('role') as $message)
                                    <div class="form-text text-danger">{{$message}}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4">كلمة المرور</label>
                    <div class="col-md-4">
                        <input type="password" name="password" class="form-control"
                               placeholder="أدخل كلمة المرور">
                        @if(!empty($messages))
                            @foreach ($messages->get('password') as $message)
                                <div class="form-text text-danger">{{$message}}</div>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-md-4">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="تأكيد كلمة المرور">
                        @if(!empty($messages))
                            @foreach ($messages->get('password_confirmation') as $message)
                                <div class="form-text text-danger">{{$message}}</div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4"></label>
                    <div class="col-sm-8">
                        <input type="submit" class="btn btn-success w-100 p-2 rounded-pill"
                               value="إضافة الحساب">
                    </div>
                </div>
            </form>
        </div>
        <!-------- END CREATE ACCOUNT SECTION ---------->
    </div>
@endsection
