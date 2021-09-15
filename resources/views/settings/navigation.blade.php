<style>
    li{
        margin: 0px 10px;
    }
    ul {
        background-color: rgba(21, 82, 213, 0.1);
        padding: 2px 0;
        border-radius: 25px;
        width: 70vw;
        margin: auto;
    }
    .nav-link.active{
        border-radius: 25px;
    }
</style>

<ul class="nav nav-pills mb-4 fw-bold justify-content-center">
    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsDatabase') ? 'active' : ''}}" href="{{Route('settingsDatabase')}}"><i class="fas fa-database"></i> قاعدة البيانات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsBooks') ? 'active' : ''}}" href="{{Route('settingsBooks')}}"><i class="fas fa-book-open"></i> قائمة الكتب</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsClients') ? 'active' : ''}}" href="{{Route('settingsClients')}}"><i class="fas fa-user"></i> قائمة الزبائن</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsAddAccount') ? 'active' : ''}}" href="{{Route('settingsAddAccount')}}"><i class="fas fa-user-plus"></i> إضافة حساب</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsEditAccount') ? 'active' : ''}}" href="{{Route('settingsEditAccount')}}"><i class="fas fa-user-edit"></i> تعديل حساب</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('settingsDeleteAccount') ? 'active' : ''}}" href="{{Route('settingsDeleteAccount')}}"><i class="fas fa-user-times"></i> حذف حساب</a>
    </li>
</ul>
