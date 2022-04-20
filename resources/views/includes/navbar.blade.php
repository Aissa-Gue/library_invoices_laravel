<!-- START Navbar -->
<nav class="navbar navbar-dark fixed-top" style="background-color: var(--my_primaryColor);">
    <a class="navbar-brand m-2" href="{{ route('home') }}">
        <img src="{{ asset('img/logo_bg.png') }}" width="40px" class="d-inline-block align-top" loading="lazy">
        برنامج الفواتير
    </a>
    <a class="navbar-brand d-none d-lg-block" href="{{ route('home') }}">
        قسم التراث والمكتبة
    </a>
    <button class="btn text-white d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLabel"
        aria-controls="offcanvasLabel"><i class="fas fa-bars"></i></button>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasLabel"
        aria-labelledby="offcanvasLabel">
        {{-- <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel">برنامج المخطوطات</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> --}}
        <div class="offcanvas-body">
            @include('includes.sidebar')
        </div>
    </div>
</nav>
<!-- END Navbar -->
