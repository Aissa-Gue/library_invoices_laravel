<style>
    #navigation li {
        margin: 0px 10px;
    }

    #navigation ul {
        background-color: rgba(21, 82, 213, 0.1);
        padding: 2px 0;
        border-radius: 25px;
        width: 50vw;
        margin: auto;
    }

    #navigation .nav-link.active {
        border-radius: 25px;
    }
</style>
<div id="navigation">
    <ul class="nav nav-pills mb-4 fw-bold justify-content-center">
        <li class="nav-item">
            <a class="nav-link {{Route::is('clientsDebts') ? 'active' : ''}}" href="{{Route('clientsDebts')}}"><i
                    class="fas fa-user"></i> ديون الزبائن </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('providersDebts') ? 'active' : ''}}" href="{{Route('providersDebts')}}"><i
                    class="fas fa-user-tie"></i> ديون المزودين </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('stockAlerts') ? 'active' : ''}}" href="{{Route('stockAlerts')}}"><i
                    class="fas fa-book-open"></i> إشعارات المخزون </a>
        </li>
    </ul>
</div>
