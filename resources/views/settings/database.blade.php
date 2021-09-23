@extends('layouts.master')

@section('content')
    @include('includes.navbars.settings.navigation')

    <div class="row mt-3">
        <div class="col-md-12">
            <h4><i class="fas fa-server fs-5"></i> إدارة قاعدة البيانات</h4>
            <hr>

            <form method="post" action="{{Route('importDB')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-3">إستيراد نسخة احتياطية (SQL)</label>
                        <div class="custom-file col-md-4">
                            <input type="file" class="form-control" name="db" accept=".sql" id="db" required>
                        </div>
                        <input type="submit" name="importDb" class="btn btn-primary" value="إستيراد">
                    </div>
                </div>
            </form>

            <!-- Third row -->
            <div class="form-group row mb-3">
                <label class="col-md-3">استخراج قاعدة البيانات</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <a href="{{Route('exportDB')}}" class="btn btn-success w-25">استخراج</a>
                    </div>
                </div>
            </div>
            <!-- END Third row -->
            <!-- Forth row -->
            <div class="form-group row mb-3">
                <label class="col-md-3">حذف قاعدة البيانات</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <a href="{{Route('dropDB')}}" class="btn btn-danger w-25"
                           onclick="return confirm('احذر ! سيتم حذف جميع البيانات نهائيا !')"> حـــــذف </a>
                    </div>
                </div>
            </div>
            <!-- END Forth row -->
        </div>
    </div>
    @endsection
