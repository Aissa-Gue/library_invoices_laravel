<style>
    #navigation li {
        margin: 0px 10px;
    }

    #navigation ul {
        background-color: rgba(21, 82, 213, 0.1);
        padding: 2px 0;
        border-radius: 25px;
        width: 28vw;
        margin: auto;
    }

    #navigation .nav-link.active {
        border-radius: 25px;
    }
</style>
<div id="navigation">
    <ul class="nav nav-pills mb-4 fw-bold justify-content-center">
        <li class="nav-item">
            <a class="nav-link {{Route::is('addClient') ? 'active' : ''}}" href="{{Route('addClient')}}"><i
                    class="fas fa-user"></i> إضافة زبون </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{Route::is('addProvider') ? 'active' : ''}}" href="{{Route('addProvider')}}"><i
                    class="fas fa-user-tie"></i> إضافة مزود </a>
        </li>
    </ul>
</div>
