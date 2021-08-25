<nav class="navbar navbar-expand-lg navbar-dark fixed-top my_bg-danger my_bg-danger">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{URL::asset('img/logo2.png')}}" alt="" width="70" height="65">
            IBN-SINA Clinic
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"></a>
                </li>
            </ul>
            <div class="d-flex">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" id="account" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{Route('account')}}"><i class="fas fa-user-circle"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="{{URL('/')}}"><i class="fas fa-home"></i> Home</a></li>

                                <li>
                                    <a href="" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

