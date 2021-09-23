@extends('layouts.master')

@section('content')
    @include('includes.navbars.settings.navigation')

    <!-------- PROVIDERS SECTION ---------->
    <div class="row mt-3">
        <div class="col-md-12">
            <h4><i class="fas fa-user-alt fs-5"></i> إدارة قائمة المزودين</h4>
            <hr>
            <form method="post" action="{{Route('importExcelProviders')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-3">إستيراد قائمة مزودين (Excel)</label>
                        <div class="custom-file col-md-4">
                            <input type="file" class="form-control" accept=".xlsx" name="providers_file" required>
                        </div>
                        <input type="submit" class="btn btn-primary" value="إستيراد">
                        <a href="{{asset('templates/providers_ex.xlsx')}}" class="btn text-dark"> <i
                                class="fas fa-download"></i> نموذج </a>
                    </div>
                </div>
            </form>

            <!-- Third row -->
            <div class="form-group row mb-3">
                <label class="col-md-3">استخراج قائمة المزودين</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <a href="{{Route('exportExcelProviders')}}" class="btn btn-success"><i
                                class="fas fa-download"></i> تحميل القائمة</a>
                    </div>
                </div>
            </div>
            <!-- END Third row -->
        </div>
    </div>
    <!-------- END PROVIDERS SECTION ---------->
@endsection
