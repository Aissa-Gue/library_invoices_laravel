@extends('layouts.master')

@section('content')
    @if (Auth::user()->role == 'admin')
        @include(
            'includes.navbars.clients-providers.navigation_list'
        )
    @endif
    <div class="alert alert-primary text-center" role="alert">
        <h4>قائمة الزبائن</h4>
    </div>
    <div class="row justify-content-sm-center mb-3">
        <div class="col-sm-7">
            <form action="{{ Route('clientsList') }}" method="get">
                <div class="input-group mb-3">
                    <span class="input-group-text">اللقب</span>
                    <input type="text" name="last_name" class="form-control" placeholder="أدخل اللقب"
                        value="{{ request('last_name') }}">

                    <span class="input-group-text">الاسم</span>
                    <input type="text" name="first_name" class="form-control" placeholder="أدخل الإسم"
                        value="{{ request('first_name') }}">
                    <button class="btn btn-primary" type="submit">بحث</button>
                </div>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="alert alert-warning text-center" role="alert">
            <strong> عدد النتائج = </strong> {{ $clients->total() }}
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">رقم الزبون</th>
                    <th scope="col">اسم الزبون</th>
                    <th scope="col">العنوان</th>
                    <th scope="col" class="text-center">رقم الهاتف 1</th>
                    <th scope="col" class="text-center">إضافة فاتورة</th>
                    <th scope="col" class="text-center">تفاصيل</th>
                    <th scope="col" class="text-center">تعديل</th>
                    @if (Auth::user()->role == 'admin')
                        <th scope="col" class="text-center">حذف</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                @empty
                    <div class="alert alert-danger text-center" role="alert">
                        لا توجد نتائج مطابقة لـ:
                        <strong> {{ request('last_name') }} {{ request('first_name') }}</strong>
                    </div>
                @endforelse

                @foreach ($clients as $client)
                    <tr>
                        <th scope="row" class="text-center">{{ $client->id }}</th>
                        <td>{{ $client->last_name . ' ' . $client->first_name . ' بن ' . $client->father_name }}</td>
                        <td>{{ $client->address }}</td>
                        <td class="text-center">0{{ $client->phone1 }}</td>

                        <td class="text-center">
                            <a class="btn btn-outline-dark" href="{{ URL('orders/add/' . $client->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z" />
                                </svg>
                            </a>
                        </td>

                        <td class="text-center">
                            <a class="btn btn-outline-success" href="{{ route('previewClient', $client->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                                </svg>
                            </a>
                        </td>

                        <td class="text-center">
                            <a class="btn btn-outline-primary" href="{{ route('editClient', $client->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>
                            </a>
                        </td>

                        <td class="text-center">
                            @if (Auth::user()->role == 'admin')
                                <form action="{{ route('deleteClient', $client->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-center fixed-bottom">
            <div class="offset-2 col-md-auto">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection
