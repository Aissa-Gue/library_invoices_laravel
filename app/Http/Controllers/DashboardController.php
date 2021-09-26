<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function cardsDetails()
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

        return compact('total_books', 'yearly_books',
            'total_orders', 'yearly_orders',
            'total_debts', 'yearly_debts',
            'total_paid_amounts', 'yearly_paid_amounts');
    }

    public function clientsDebts(Request $request)
    {
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $debts = Order::join('clients', 'orders.client_id', 'clients.person_id')
            ->join('people', 'orders.client_id', 'people.id')
            ->where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->select('orders.id', 'client_id', 'orders.required_amount', 'orders.paid_amount', 'orders.created_at', 'last_name', 'first_name', 'father_name', DB::raw('SUM(required_amount - paid_amount) as debt_amount'))
            ->havingRaw('debt_amount > ?', [0])
            ->groupBy('orders.id')
            ->orderBy('client_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('dashboard.clients_debts')
            ->with(compact('debts'))
            ->with($this->cardsDetails());
    }

    public function providersDebts(Request $request)
    {
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $debts = Purchase::join('providers', 'purchases.provider_id', 'providers.person_id')
            ->join('people', 'people.id', 'providers.person_id')
            ->where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->select('purchases.id', 'provider_id', 'purchases.required_amount', 'purchases.paid_amount', 'purchases.created_at', 'last_name', 'first_name', 'father_name', DB::raw('SUM(required_amount - paid_amount) as debt_amount'))
            ->havingRaw('debt_amount > ?', [0])
            ->groupBy('purchases.id')
            ->orderBy('person_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('dashboard.providers_debts')
            ->with(compact('debts'))
            ->with($this->cardsDetails());
    }

    public function stockAlerts()
    {
        $alert_books = Book::where('quantity', '<', 6)
            ->select('id', 'title', 'author', 'quantity')
            ->paginate(15);
        return view('dashboard.stock_alerts')
            ->with(compact('alert_books'))
            ->with($this->cardsDetails());
    }

    public function index()
    {
        return redirect()->route('clientsDebts');

        /*
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
        */
    }
}
