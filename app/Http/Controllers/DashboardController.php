<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function cardsDetails()
    {
        /******* CARDS *******/
        //books
        $monthly_books = Book::select(DB::raw('COUNT(*) as monthly_books'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        $yearly_books = Book::select(DB::raw('COUNT(*) as yearly_books'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //orders
        $monthly_orders = Order::select(DB::raw('COUNT(*) as monthly_orders'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        $yearly_orders = Order::select(DB::raw('COUNT(*) as yearly_orders'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //Debts
        $monthly_debts = Order::select(DB::raw('SUM(required_amount - paid_amount) as monthly_debts'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        $yearly_debts = Order::select(DB::raw('SUM(required_amount - paid_amount) as yearly_debts'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //sales
        $monthly_sales = Sale::select(DB::raw('SUM(sale_price * quantity) as monthly_sales'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        $yearly_sales = Sale::select(DB::raw('SUM(sale_price * quantity) as monthly_sales'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        //paid amounts
        $monthly_paid_amounts = Order::select(DB::raw('SUM(paid_amount) as monthly_paid_amounts'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
        $yearly_paid_amounts = Order::select(DB::raw('SUM(paid_amount) as yearly_paid_amounts'))
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        return compact('monthly_books', 'yearly_books',
            'monthly_orders', 'yearly_orders',
            'monthly_debts', 'yearly_debts',
            'monthly_sales', 'yearly_sales',
            'monthly_paid_amounts', 'yearly_paid_amounts');
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
            ->orderBy('orders.created_at', 'DESC')
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
            ->orderBy('purchases.created_at', 'DESC')
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
        return redirect()->route('stockAlerts');

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
