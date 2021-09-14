@extends('layouts.master')

@section('content')
    @include('settings.navigation')


    <!-------- BOOKS SECTION ---------->
    <div class="row mt-3">
        <div class="col-md-12">
            <h4><i class="fas fa-book-open fs-5"></i> إدارة قائمة الكتب</h4>
            <hr>

            <form method="post" action="{{Route('importExcelBooks')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-3">
                    <div class="input-group">
                        <label class="col-md-3">إستيراد قائمة كتب (Excel)</label>
                        <div class="custom-file col-md-4">
                            <input type="file" class="form-control" accept=".xlsx" name="books_file" required>
                        </div>
                        <input type="submit" class="btn btn-primary" value="إستيراد">
                        <a href="{{asset('templates/books_ex.xlsx')}}" class="btn text-dark"> <i
                                class="fas fa-download"></i> نموذج </a>
                    </div>
                </div>
            </form>

            <!-- Third row -->
            <div class="form-group row mb-3">
                <label class="col-md-3">استخراج قائمة الكتب</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <a href="{{Route('exportExcelBooks')}}" class="btn btn-success"><i
                                class="fas fa-download"></i> تحميل القائمة</a>
                    </div>
                </div>
            </div>
            <!-- END Third row -->
        </div>
    </div>
    <!-------- END BOOKS SECTION ---------->

@endsection
