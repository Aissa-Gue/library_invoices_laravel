@extends('layouts.master')

@section('content')
    <div class="alert alert-primary text-center" role="alert">
        <h4>قائمة الكتب</h4>
    </div>
    <div class="row justify-content-sm-center mb-3">
        <div class="col-sm-8">
            <form action="{{ Route('booksList') }}" method="get">
                <div class="input-group mb-3">
                    <span class="input-group-text">عنوان الكتاب</span>
                    <input type="text" name="title" class="form-control" placeholder="أدخل العنوان"
                        value="{{ request('title') }}">

                    <span class="input-group-text">المؤلف</span>
                    <input type="text" name="author" class="form-control" placeholder="أدخل المؤلف"
                        value="{{ request('author') }}">
                    <button class="btn btn-primary" name="Search" type="submit">بحث</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="alert alert-warning text-center" role="alert">
            <strong> عدد النتائج = </strong>{{ $books->total() }}
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">رقم الكتاب</th>
                    <th scope="col">عنوان الكتاب</th>
                    <th scope="col">المؤلف</th>
                    <th scope="col" class="text-center">الكمية</th>
                    <th scope="col" class="text-center">سعر البيع</th>
                    <th scope="col" class="text-center">تفاصيل</th>
                    <th scope="col" class="text-center">تعديل</th>
                    @if (Auth::user()->role == 'admin')
                        <th scope="col" class="text-center">حذف</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                @empty
                    <div class="alert alert-danger text-center" role="alert">
                        لا توجد نتائج مطابقة لـ:
                        <strong> {{ request('title') }} * {{ request('author') }}</strong>
                    </div>
                @endforelse

                @foreach ($books as $book)
                    <tr>
                        <th scope="row" class="text-center">{{ $book->id }}</th>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td class="text-center">{{ $book->quantity }}</td>
                        <td class="text-center">
                            {{ number_format($book->purchase_price + ($book->purchase_price * $book->sale_percentage) / 100, 2) }}
                        </td>

                        <td class="text-center">
                            <a class="btn btn-outline-success" href="{{ route('previewBook', $book->id) }}">
                                <i class="fas fa-list"></i>
                            </a>
                        </td>

                        <td class="text-center">
                            <a class="btn btn-outline-primary" href="{{ route('editBook', $book->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>
                            </a>
                        </td>

                        @if (Auth::user()->role == 'admin')
                            <td class="text-center">
                                <form action="{{ route('deleteBook', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-center fixed-bottom">
            <div class="offset-2 col-md-auto">
                {{ $books->links() }}
            </div>
        </div>
    </div>
@stop
