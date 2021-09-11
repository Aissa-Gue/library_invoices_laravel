@extends('layouts.master')

@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="#database" data-bs-toggle="tab" data-bs-target="#database" type="button"
               role="tab"
               aria-controls="database" aria-selected="true">قاعدة البيانات
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" href="#books" data-bs-toggle="tab" data-bs-target="#books" type="button" role="tab"
               aria-controls="books" aria-selected="false">قائمة الكتب
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" href="#clients" data-bs-toggle="tab" data-bs-target="#clients" type="button" role="tab"
               aria-controls="clients" aria-selected="false">قائمة الزبائن
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" href="#account" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab"
               aria-controls="account" aria-selected="false">إعدادات الحساب
            </a>
        </li>
    </ul>


    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="database" role="tabpanel">
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
        </div>


        <!-------- BOOKS SECTION ---------->
        <div class="tab-pane fade" id="books" role="tabpanel">
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
        </div>
        <!-------- END BOOKS SECTION ---------->


        <!-------- CLIENTS SECTION ---------->
        <div class="tab-pane fade" id="clients" role="tabpanel">
            <div class="row mt-3">
                <div class="col-md-12">
                    <h4><i class="fas fa-user-alt fs-5"></i> إدارة قائمة الزبائن</h4>
                    <hr>
                    <form method="post" action="{{Route('importExcelClients')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="input-group">
                                <label class="col-md-3">إستيراد قائمة زبائن (Excel)</label>
                                <div class="custom-file col-md-4">
                                    <input type="file" class="form-control" accept=".xlsx" name="clients_file" required>
                                </div>
                                <input type="submit" class="btn btn-primary" value="إستيراد">
                                <a href="{{asset('templates/clients_ex.xlsx')}}" class="btn text-dark"> <i
                                        class="fas fa-download"></i> نموذج </a>
                            </div>
                        </div>
                    </form>

                    <!-- Third row -->
                    <div class="form-group row mb-3">
                        <label class="col-md-3">استخراج قائمة الزبائن</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <a href="{{Route('exportExcelClients')}}" class="btn btn-success"><i
                                        class="fas fa-download"></i> تحميل القائمة</a>
                            </div>
                        </div>
                    </div>
                    <!-- END Third row -->
                </div>
            </div>
        </div>
        <!-------- END CLIENTS SECTION ---------->


        <!-------- ACCOUNT SECTION ---------->
        <div class="tab-pane fade" id="account" role="tabpanel">
            <div class="row mt-3">
                <div class="col-md-12">
                    <h4><i class="fas fa-user-circle fs-5"></i> تغيير إعدادات تسجيل الدخول</h4>
                    <hr>
                    <form method="post" action="{{Route('importExcelClients')}}" enctype="multipart/form-data">
                    @csrf
                    <!-- First row -->
                        <div class="form-group row mb-3">
                            <div class="input-group">
                                <label class="col-md-2">كلمة المرور القديمة</label>
                                <div class="col-md-4">
                                    <input type="password" name="oldPwd" class="form-control"
                                           placeholder="أدخل كلمة المرور القديمة" required/>
                                </div>
                            </div>
                        </div>
                        <!-- END First row -->

                        <!-- Second row -->
                        <div class="form-group row mb-3">
                            <div class="input-group">
                                <label class="col-md-2">اسم المستخدم الجديد</label>
                                <div class="col-md-4">
                                    <input type="text" name="newUsername" class="form-control"
                                           placeholder="أدخل اسم المستخدم الجديد" required/>
                                </div>
                            </div>
                        </div>
                        <!-- END second row -->

                        <!-- Third row -->
                        <div class="form-group row mb-3">
                            <label class="col-md-2">كلمة المرور الجديدة</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="password" name="newPwd1" class="form-control"
                                           placeholder="أدخل كلمة المرور الجديدة">
                                </div>
                            </div>
                        </div>
                        <!-- END Third row -->
                        <!-- Forth row -->
                        <div class="form-group row mb-3">
                            <label class="col-md-2">تأكيد كلمة المرور</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="password" name="newPwd2" class="form-control"
                                           placeholder="أعد إدخال كلمة المرور الجديدة">
                                </div>
                            </div>
                        </div>
                        <!-- END Forth row -->
                        <div class="form-group row mb-3">
                            <label class="col-md-2"></label>
                            <div class="col-sm-4">
                                <input type="submit" name="editAcc"
                                       class="btn btn-success w-100 p-2 rounded-pill"
                                       value="تغيير الإعدادات">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-------- END ACCOUNT SECTION ---------->

    </div>
@endsection
