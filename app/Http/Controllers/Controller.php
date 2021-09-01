<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Order_Book;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        /******* CARDS *******/
        //books
        $total_books = Book::select(DB::raw('COUNT(*) as total_books'))->first();
        $yearly_books = Book::select(DB::raw('COUNT(*) as yearly_books'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //orders
        $total_orders = Order::select(DB::raw('COUNT(*) as total_orders'))->first();
        $yearly_orders = Order::select(DB::raw('COUNT(*) as yearly_orders'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //Debts
        $total_debts = Order::select(DB::raw('SUM(required_amount - paid_amount) as total_debts'))->first();
        $yearly_debts = Order::select(DB::raw('SUM(required_amount - paid_amount) as yearly_debts'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //paid amounts
        $total_paid_amounts = Order::select(DB::raw('SUM(paid_amount) as total_paid_amounts'))->first();
        $yearly_paid_amounts = Order::select(DB::raw('SUM(paid_amount) as yearly_paid_amounts'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        /******* Tables *******/
        $debts = Order::join('clients', 'orders.client_id', 'clients.id')
            ->select('orders.id', 'orders.created_at', 'last_name', 'first_name', 'father_name', DB::raw('SUM(required_amount - paid_amount) as debt_amount'))
            ->havingRaw('debt_amount > ?', [0])
            ->groupBy('orders.id')
            ->get();

        ////
        $monthly_paid_amounts = Order::select(DB::raw('MONTH(orders.created_at) as month_nbr, MONTHNAME(orders.created_at) as month_name, SUM(required_amount) as required_amount'))
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->groupBy("month_name")
            ->orderBy('month_nbr')
            ->get();


        $alert_books = Book::where('quantity','<',6)
            ->select('id','title','quantity')
            ->get();

        $monthly_paid_amounts = Order::join('order__books', 'order__books.order_id', 'orders.id')
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->select('order_id',
                DB::raw('MONTH(orders.created_at) as month_nbr,
                MONTHNAME(orders.created_at) as month_name,
                SUM(purchase_price * quantity) as purchase_price,
                SUM(quantity) as total_books'
                )
            )
            ->groupBy('month_name')
            ->orderBy('month_nbr')
            ->get();


        return view('welcome')->with
        (
            compact('total_books', 'yearly_books',
                'total_orders', 'yearly_orders',
                'total_debts', 'yearly_debts',
                'total_paid_amounts', 'yearly_paid_amounts',
                'debts', 'alert_books')
        );
    }
}
