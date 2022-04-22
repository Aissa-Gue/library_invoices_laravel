@extends('layouts.master')

@section('content')
    @include('includes.navbars.settings.navigation')

    <div class="row">
        <div class="col-md-6">
            <h4><i class="fas fa-user-times"></i> حذف حساب</h4>
            <hr class="mb-4">
            <form method="post" action="{{ Route('deleteAccount') }}">
                @method('delete')
                @csrf
                <div class="form-group row mb-3">
                    <label class="col-md-4">كلمة مرور المسؤول</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="password" name="admin_password" class="form-control"
                                placeholder="أدخل كلمة مرور المسؤول" required />
                        </div>
                        @if (!empty($messages))
                            @foreach ($messages->get('admin_password') as $message)
                                <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4">اختر مستخدم</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <select id="username" class="form-select @error('username') is-invalid @enderror"
                                name="username" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-danger" type="submit">حذف</button>
                        </div>
                        @if (!empty($messages))
                            @foreach ($messages->get('username') as $message)
                                <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
