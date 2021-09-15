<style>
    li{
        margin: 0px 10px;
    }
    ul {
        background-color: rgba(21, 82, 213, 0.1);
        padding: 2px 0;
        border-radius: 25px;
        width: 40vw;
        margin: auto;
    }
    .nav-link.active{
        border-radius: 25px;
    }
</style>
<ul class="nav nav-pills mb-4 fw-bold justify-content-center">
    <li class="nav-item">
        <a class="nav-link {{Route::is('trashedBooks') ? 'active' : ''}}" href="{{Route('trashedBooks')}}"><i
                class="fas fa-book-open"></i> الكتب </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('trashedClients') ? 'active' : ''}}" href="{{Route('trashedClients')}}"><i
                class="fas fa-user"></i> الزبائن </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{Route::is('trashedOrders') ? 'active' : ''}}" href="{{Route('trashedOrders')}}"><i
                class="fas fa-file-invoice-dollar"></i> الفواتير </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{Route::is('trashedUsers') ? 'active' : ''}}" href="{{Route('trashedUsers')}}"><i
                class="fas fa-user-shield"></i> المستخدمين </a>
    </li>
</ul>
