@extends('layouts.master')

@section('content')
    @include('includes.navbars.trash.navigation')

    <!-------- ORDERS SECTION ---------->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-danger text-center" role="alert">
                <h5><i class="fas fa-file-invoice-dollar"></i> فواتير الزبائن المحذوفة</h5>
            </div>
        </div>

        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                <tr class="text-secondary">
                    <th scope="col">#</th>
                    <th scope="col">الزبون</th>
                    <th scope="col">نوع الفاتورة</th>
                    <th scope="col" class="text-center">المبلغ الإجمالي</th>
                    <th scope="col" class="text-center">ديون</th>
                    <th scope="col" class="text-center">تاريخ الحذف</th>
                    <th scope="col" class="text-center">استرجاع</th>
                    <th scope="col" class="text-center">حذف نهائي</th>
                </tr>
                </thead>
                <tbody>
                @if($trashedOrders->isEmpty())
                    <tr class="fw-bold text-center text-danger">
                        <td colspan="8" class="py-4"><i class="fas fa-exclamation-triangle fs-4 mb-3"></i><br>  لا توجد فواتير محذوفة !</td>
                    </tr>
                @endif
                @foreach($trashedOrders as $trashedOrder)
                    <tr class="fw-bold">
                        <th class="text-danger"><i class="fas fa-arrow-alt-circle-left fs-5"></i></th>
                        <td>{{$trashedOrder->client->person->last_name.' '.$trashedOrder->client->person->first_name.' بن '.$trashedOrder->client->person->father_name}}</td>
                        <td>{{$trashedOrder->type}}</td>
                        <td class="text-center">{{number_format($trashedOrder->required_amount,2)}} دج</td>
                        <td class="text-center text-danger">{{number_format($trashedOrder->required_amount - $trashedOrder->paid_amount,2)}} دج</td>
                        <td class="text-center">{{$trashedOrder->deleted_at}}</td>
                        <td class="text-center">
                            <form action="{{route('restoreTrashedOrder', $trashedOrder->id)}}" method="POST">
                                @csrf
                                <button class="btn btn-outline-success"
                                        type="submit"
                                        onclick="return confirm('هل أنت متأكد؟')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-recycle" viewBox="0 0 16 16">
                                        <path
                                            d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <form action="{{route('deleteTrashedOrder', $trashedOrder->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger"
                                        type="submit"
                                        onclick="return confirm('هل أنت متأكد؟')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center fixed-bottom">
                <div class="offset-2 col-md-auto">
                    {{$trashedOrders->links()}}
                </div>
            </div>
        </div>
    </div>
    <!-------- END ORDERS SECTION ---------->

@endsection
