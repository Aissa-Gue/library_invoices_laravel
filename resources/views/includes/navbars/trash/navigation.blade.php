<style>
    #navigation li {
        margin: 0px 10px;
    }

    #navigation ul {
        background-color: rgba(21, 82, 213, 0.1);
        padding: 2px 0;
        border-radius: 25px;
        width: 80vw;
        margin: auto;
    }

    #navigation .nav-link.active {
        border-radius: 25px;
    }
</style>
<div id="navigation">
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
            <a class="nav-link {{Route::is('trashedProviders') ? 'active' : ''}}"
               href="{{Route('trashedProviders')}}"><i
                    class="fas fa-user-tie"></i> المزودين </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{Route::is('trashedSales') ? 'active' : ''}}" href="{{Route('trashedSales')}}"><i
                    class="fas fa-shopping-cart"></i> المبيعات </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{Route::is('trashedOrders') ? 'active' : ''}}" href="{{Route('trashedOrders')}}"><i
                    class="fas fa-file-invoice-dollar"></i> فواتير الزبائن </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('trashedPurchases') ? 'active' : ''}}"
               href="{{Route('trashedPurchases')}}"><i
                    class="fas fa-file-invoice-dollar"></i> فواتير المزودين </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('trashedUsers') ? 'active' : ''}}" href="{{Route('trashedUsers')}}"><i
                    class="fas fa-user-shield"></i> المستخدمين </a>
        </li>
    </ul>
</div>
