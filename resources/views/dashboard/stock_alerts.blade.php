@extends('layouts.master')

@section('content')
    @include('includes.navbars.dashboard.navigation')
    @include('dashboard.cards')
    <!-- table 2 -->
    <div class="row">
        <div class="col-md-12">
            <div class="mx-1 flex-md-fill bd-highlight shadow bg-body rounded p-2">
                <table class="table table-hover caption-top m-0">
                    <caption class="alert alert-danger text-center fw-bold" role="alert">
                        الكتب القريبة النفاذ
                    </caption>
                    <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">العنوان</th>
                        <th scope="col">المؤلف</th>
                        <th scope="col" class="text-center">الكمية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($alert_books->isEmpty())
                        <th scope="row" colspan="4" class="text-center text-success">لا توجد كتب قريبة النفاذ !</th>
                    @endif
                    @foreach($alert_books as $alert_book)
                        <tr>
                            <th scope="row">{{$alert_book->id}}</th>
                            <td>{{$alert_book->title}}</td>
                            <td>{{$alert_book->author}}</td>
                            <td class="text-center text-danger fw-bold">{{$alert_book->quantity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center fixed-bottom">
                    <div class="offset-2 col-md-auto">
                        {{$alert_books->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END table 1 -->
@endsection
