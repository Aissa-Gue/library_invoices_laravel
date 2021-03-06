<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> فاتورة {{$order->id}}</title>
    @include('includes.requirements')
</head>

<body>
<div class="container-fluid">
    @include('orders.print.layouts.header')

    @yield('content')

    @include('orders.print.layouts.footer')
</div>
</body>

<script type="text/javascript">
    $(document).ready(function () {
        window.print();
    })
    window.onafterprint = function () {
        history.go(-1);
    };
</script>
