<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Client;
use App\Models\Order;
use App\Models\Order_Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function calculate($id)
    {
        $order = Order::findOrFail($id);
        $orderBooks = Order_Book::where('order_id', $id)->get();

        $discBooks = DB::table("order__books")
            ->Join("books", function ($join) {
                $join->on("books.id", "=", "order__books.book_id");
            })
            ->select(DB::raw('sum(order__books.quantity * order__books.purchase_price) As purchase_price_sum'), DB::raw('sum(order__books.quantity * order__books.sale_price) As sale_price_sum'), DB::raw('sum(order__books.quantity) As quantity'))
            ->where("order__books.order_id", "=", $id)
            ->where("books.discount", "=", 1)
            ->groupBy("order__books.order_id")
            ->first();

        $NonDiscBooks = DB::table("order__books")
            ->Join("books", function ($join) {
                $join->on("books.id", "=", "order__books.book_id");
            })
            ->select(DB::raw('sum(order__books.quantity * order__books.purchase_price) As purchase_price_sum'), DB::raw('sum(order__books.quantity * order__books.sale_price) As sale_price_sum'), DB::raw('sum(order__books.quantity) As quantity'))
            ->where("order__books.order_id", "=", $id)
            ->where("books.discount", "=", 0)
            ->groupBy("order__books.order_id")
            ->first();

        if (!empty($discBooks) and !empty($NonDiscBooks)) {
            $total_quantity = $discBooks->quantity + $NonDiscBooks->quantity;
            $total_purchase_price = $discBooks->purchase_price_sum + $NonDiscBooks->purchase_price_sum;
            $total_sale_price = $discBooks->sale_price_sum + $NonDiscBooks->sale_price_sum;
            $total_discountable_price = $NonDiscBooks->sale_price_sum + $discBooks->sale_price_sum - ($discBooks->sale_price_sum * $order->discount_percentage / 100);


        } elseif (empty($discBooks) and empty($NonDiscBooks)) {
            $total_quantity = $total_purchase_price = $total_sale_price = $total_discountable_price = 0;

        } elseif (empty($discBooks)) {
            //if discountable books NOT FOUND
            $total_quantity = $NonDiscBooks->quantity;
            $total_purchase_price = $NonDiscBooks->purchase_price_sum;
            $total_sale_price = $NonDiscBooks->sale_price_sum;
            $total_discountable_price = $NonDiscBooks->sale_price_sum;

        } elseif (empty($NonDiscBooks)) {
            //if non discountable books NOT FOUND
            $total_quantity = $discBooks->quantity;
            $total_purchase_price = $discBooks->purchase_price_sum;
            $total_sale_price = $discBooks->sale_price_sum;
            $total_discountable_price = $discBooks->sale_price_sum - ($discBooks->sale_price_sum * $order->discount_percentage / 100);
        }


        return array(
            'order' => $order,
            'orderBooks' => $orderBooks,
            'total_quantity' => $total_quantity,
            'total_purchase_price' => $total_purchase_price,
            'total_sale_price' => $total_sale_price,
            'total_discountable_price' => $total_discountable_price
        );
    }


    public function showAllData(Request $request)
    {
        $lname = $request->get('last_name');
        $fname = $request->get('first_name');
        $type = $request->get('type');
        $order_id = $request->get('order_id');

        $orders = Order::join('clients', 'clients.id', '=', 'orders.client_id')
            ->where('last_name', 'LIKE', '%' . $lname . '%')
            ->where('first_name', 'LIKE', '%' . $fname . '%')
            ->where('type', 'LIKE', '%' . $type . '%')
            ->where('orders.id', 'LIKE', '%' . $order_id)
            ->select('orders.id', 'orders.type', 'orders.discount_percentage', 'orders.created_at', 'last_name', 'first_name', 'father_name')
            ->paginate(10);


        return view('orders.orders_list')->with('orders', $orders);
    }

    public function show($id)
    {
        $order = $this->calculate($id)['order'];
        $orderBooks = $this->calculate($id)['orderBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];
        $total_discountable_price = $this->calculate($id)['total_discountable_price'];

        return view('orders.preview_order')
            ->with(compact('order', 'orderBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price', 'total_discountable_price'));
    }

    public function add()
    {
        $clients = Client::all();
        return view('orders.add_order')->with('clients', $clients);
    }

    public function store(Request $request)
    {
        $client = explode(' # ', $request->client_id);
        $request->request->set('client_id', $client[0]);

        $validated = $request->validate([
            'type' => 'required|alpha',
            'client_id' => 'required|numeric|exists:clients,id',
            'discount_percentage' => 'required|numeric',
        ]);
        $order = Order::Create($validated);
        return redirect(Route('editOrder', $order->id));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'discount_percentage' => 'required|numeric',
            'paid_amount' => 'required|numeric',
        ]);
        $order = Order::find($id)->update($validated);
        return redirect(Route('editOrder', $id));
    }


    public function edit($id)
    {
        $order = $this->calculate($id)['order'];
        $orderBooks = $this->calculate($id)['orderBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];
        $total_discountable_price = $this->calculate($id)['total_discountable_price'];

        return view('orders.edit_order')
            ->with(compact('order', 'orderBooks', 'orderBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price', 'total_discountable_price'));
    }

    public function storeBook($id, Request $request)
    {
        //get book info
        $book = explode(' # ', $request->book_id);
        $Current_book = Book::find($book[0]);
        //add fields from DB
        $request->request->add(
            [
                'book_id' => $book[0],
                'order_id' => $id,
                'purchase_price' => $Current_book->purchase_price,
                'sale_price' => $Current_book->sale_price
            ]
        );

        $validated = $request->validate([
            'order_id' => 'required|numeric|exists:orders,id',
            'book_id' => 'required|numeric|exists:books,id',
            'quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);

        Order_Book::Create($validated);
        return redirect(Route('editOrder', $id));
    }

    public function destroyBook($id, $book_id)
    {
        Order_Book::where('order_id', $id)->where('book_id', $book_id)->delete();
        return redirect(Route('editOrder', $id));
    }

    public function destroy($id)
    {
        Order_Book::where('order_id', $id)->delete();
        Order::find($id)->delete();
        return redirect(Route('ordersList'));
    }
}