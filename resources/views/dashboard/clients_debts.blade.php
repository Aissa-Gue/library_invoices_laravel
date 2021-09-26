@extends('layouts.master')

@section('content')
    @include('includes.navbars.dashboard.navigation')
    @include('dashboard.cards')
    <div class="row">
        <!-- table 1 -->
        <div class="col-md-12">
            <div class="mx-1 flex-md-fill bd-highlight shadow bg-body rounded p-2">
                <div class="alert alert-danger text-center fw-bold" role="alert">
                    قائمة ديون الزبائن
                </div>

                <div class="row justify-content-sm-center mb-3">
                    <div class="col-sm-7">
                        <form action="{{Route('clientsDebts')}}" method="get">
                            <div class="input-group mb-3">
                                <span class="input-group-text">اللقب</span>
                                <input type="text" name="last_name" class="form-control"
                                       placeholder="أدخل اللقب" value="{{request('last_name')}}">

                                <span class="input-group-text">الاسم</span>
                                <input type="text" name="first_name" class="form-control"
                                       placeholder="أدخل الإسم" value="{{request('first_name')}}">
                                <button class="btn btn-primary" type="submit">بحث</button>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-hover caption-top m-0">
                    <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center"><i class="fas fa-radiation text-secondary fs-5"></i></th>
                        <th scope="col" class="text-center">رقم الفاتورة</th>
                        <th scope="col">الزبون</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">المبلغ المتبقي</th>
                        <th scope="col" class="text-center">الفاتورة</th>
                        <th scope="col" class="text-center">الزبون</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($debts->isEmpty())
                        <tr class="fw-bold text-center text-danger">
                            <td colspan="7" class="py-4"><i class="fas fa-exclamation-triangle fs-4 mb-3"></i><br> لا وجود
                                لزبائن لديهم ديون !
                            </td>
                        </tr>
                    @endif
                    @foreach($debts as $debt)
                        <tr>
                            <th scope="row" class="text-center fs-5">
                                @if($debt->required_amount > $debt->paid_amount and $debt->paid_amount == 0)
                                    <i class="fas fa-times-circle text-danger"></i>
                                @elseif($debt->required_amount > $debt->paid_amount)
                                    <i class="fas fa-exclamation-circle text-warning"></i>
                                @endif
                            </th>
                            <th scope="row" class="text-center">{{$debt->id}}</th>
                            <td>{{$debt->last_name .' '. $debt->first_name .' بن '.$debt->father_name}}</td>
                            <td>{{$debt->created_at->todatestring()}}</td>
                            <td class="text-secondary">
                                @if($debt->debt_amount == null)
                                    <span class="text-danger fw-bold">0.00</span> دج
                                @else
                                    <span class="text-danger fw-bold">{{number_format($debt->debt_amount,2)}}</span> دج
                                @endif
                            </td>
                            <th scope="row" class="text-center"><a href="{{Route('previewOrder',$debt->id)}}"
                                                                   class="btn btn-outline-success"><i
                                        class="fad fa-shopping-cart"></i></a></th>
                            <th scope="row" class="text-center"><a href="{{Route('previewClient',$debt->client_id)}}"
                                                                   class="btn btn-outline-primary"><i
                                        class="fas fa-user"></i></a></th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row justify-content-center fixed-bottom">
                    <div class="offset-2 col-md-auto">
                        {{$debts->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- END table 1 -->
    </div>

@endsection
