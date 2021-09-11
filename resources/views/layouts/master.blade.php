<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>المكتبة المركزية | برنامج الفواتير</title>

    @include('includes.requirements')
    @livewireStyles
</head>

<body class="my_bg">
@include('includes.navbar')

<div class="container-fluid my_mt">
    <div class="row">
        <div class="col-sm-2">
            @include('includes.sidebar')
        </div>
        <div class="col-sm-10">
            @yield('content')
        </div>
    </div>
</div>
@livewireScripts

</body>
</html>

