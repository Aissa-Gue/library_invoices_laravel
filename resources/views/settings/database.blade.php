@extends('layouts.master')

@section('content')
    @include('includes.navbars.settings.navigation')

    <div class="row mt-3">
        <div class="col-md-12">
            <h4><i class="fas fa-server fs-5"></i> إدارة قاعدة البيانات</h4>
            <hr>
            @if (session()->has('successImportDbAlert') or session()->has('successExportDbAlert'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div>
                        @if (session()->has('successImportDbAlert'))
                            {{ session()->get('successImportDbAlert') }}
                        @elseif(session()->has('successExportDbAlert'))
                            {{ session()->get('successExportDbAlert') }}
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('failImportDbAlert') or session()->has('failExportDbAlert') or session()->has('dropDbAlert'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center fw-bold mt-3" role="alert">
                    <i class="fas fa-times-circle me-2 fs-5"></i>
                    <div>
                        @if (session()->has('failImportDbAlert'))
                            {{ session()->get('failImportDbAlert') }}
                        @elseif(session()->has('failExportDbAlert'))
                            {{ session()->get('failExportDbAlert') }}
                        @elseif(session()->has('dropDbAlert'))
                            {{ session()->get('dropDbAlert') }}
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="post" action="{{ Route('importDB') }}" enctype="multipart/form-data">
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
                        <a href="{{ Route('exportDB') }}" class="btn btn-success"><i class="fas fa-download"></i>
                            استخراج</a>
                    </div>
                </div>
            </div>
            <!-- END Third row -->
            <!-- Forth row -->
            <div class="form-group row mb-3">
                <label class="col-md-3">حذف قاعدة البيانات</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <a href="{{ Route('dropDB') }}" class="btn btn-danger"
                            onclick="return confirm('احذر ! سيتم حذف جميع البيانات نهائيا !')"><i
                                class="fas fa-times"></i> حـــــذف </a>
                    </div>
                </div>
            </div>
            <!-- END Forth row -->
        </div>
    </div>
@endsection
