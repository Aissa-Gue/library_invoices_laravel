<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function calculate($id)
    {
        $order = Order::findOrFail($id);
        $orderBooks = OrderBook::where('order_id', $id)->get();

        $discBooks = DB::table("order_books")
            ->Join("books", function ($join) {
                $join->on("books.id", "=", "order_books.book_id");
            })
            ->select(DB::raw('sum(order_books.quantity * order_books.purchase_price) As purchase_price_sum'),
                DB::raw('sum(order_books.quantity * order_books.sale_price) As sale_price_sum'),
                DB::raw('sum(order_books.quantity) As quantity'))
            ->where("order_books.order_id", "=", $id)
            ->where("books.discount", "=", 1)
            ->groupBy("order_books.order_id")
            ->first();

        $NonDiscBooks = DB::table("order_books")
            ->Join("books", function ($join) {
                $join->on("books.id", "=", "order_books.book_id");
            })
            ->select(DB::raw('sum(order_books.quantity * order_books.purchase_price) As purchase_price_sum'),
                DB::raw('sum(order_books.quantity * order_books.sale_price) As sale_price_sum'),
                DB::raw('sum(order_books.quantity) As quantity'))
            ->where("order_books.order_id", "=", $id)
            ->where("books.discount", "=", 0)
            ->groupBy("order_books.order_id")
            ->first();

        if (!empty($discBooks) and !empty($NonDiscBooks)) {
            $total_quantity = $discBooks->quantity + $NonDiscBooks->quantity;
            $total_purchase_price = $discBooks->purchase_price_sum + $NonDiscBooks->purchase_price_sum;
            $total_sale_price = $discBooks->sale_price_sum + $NonDiscBooks->sale_price_sum;
            $total_discountable_price = ($NonDiscBooks->sale_price_sum + $discBooks->sale_price_sum) - ($discBooks->sale_price_sum * $order->discount_percentage / 100);


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

    public function updateRequiredAmount($id)
    {
        $total_discountable_price = $this->calculate($id)['total_discountable_price'];
        Order::where('id', $id)->update(['required_amount' => $total_discountable_price]);
    }

    public function updatedBy($id)
    {
        Order::where('id', $id)->update(['updated_by' => Auth::user()->id]);
    }

    public function incrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->increment('quantity', $quantity);
    }

    public function decrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->decrement('quantity', $quantity);
    }

    public function isSellerAndGift($order_id)
    {
        //redirect if the seller try to access to gift orders
        $role = Auth::user()->role;
        $order = Order::where('id', $order_id)->first();
        if ($role == 'seller' and $order->type == 'إهداء') {
            return true;
        } else {
            return false;
        }
    }

    public function showAllData(Request $request)
    {
        $lname = $request->get('last_name');
        $fname = $request->get('first_name');
        $type = $request->get('type');
        $order_id = $request->get('order_id');

        //if role is [ADMIN] show all orders elseif [USER] hide orders where type= gift
        if (Auth::user()->role == 'admin') {
            $orders = Order::join('clients', 'clients.id', '=', 'orders.client_id')
                ->where('last_name', 'LIKE', '%' . $lname . '%')
                ->where('first_name', 'LIKE', '%' . $fname . '%')
                ->where('type', 'LIKE', '%' . $type . '%')
                ->where('orders.id', 'LIKE', '%' . $order_id)
                ->select('orders.id', 'orders.type', 'orders.discount_percentage', 'orders.required_amount', 'orders.paid_amount', 'orders.created_at', 'last_name', 'first_name', 'father_name')
                ->orderBy('created_at', 'DESC')
                ->paginate(15);

        } elseif (Auth::user()->role == 'seller') {
            $orders = Order::join('clients', 'clients.id', '=', 'orders.client_id')
                ->where('last_name', 'LIKE', '%' . $lname . '%')
                ->where('first_name', 'LIKE', '%' . $fname . '%')
                ->where('type', 'LIKE', '%' . $type . '%')
                ->where('orders.id', 'LIKE', '%' . $order_id)
                ->where('type', '!=', 'إهداء')
                ->select('orders.id', 'orders.type', 'orders.discount_percentage', 'orders.created_at', 'last_name', 'first_name', 'father_name')
                ->orderBy('created_at', 'DESC')
                ->paginate(15);
        }

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

        //redirect if the seller try to access to gift orders
        if ($this->isSellerAndGift($id)) {
            return redirect()->route('ordersList');
        }

        return view('orders.preview_order')
            ->with(compact('order', 'orderBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price', 'total_discountable_price'));
    }

    public function print($id, Request $req)
    {
        $order = $this->calculate($id)['order'];
        $orderBooks = $this->calculate($id)['orderBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];
        $total_discountable_price = $this->calculate($id)['total_discountable_price'];

        //redirect if the seller try to access to gift orders
        if ($this->isSellerAndGift($id)) {
            return redirect()->route('ordersList');
        }

        if ($order->type == 'إهداء') {
            if ($req->invoice == 'seller') {
                $view = view('orders.print.gift1_A4');

            } elseif ($req->invoice == 'buyer') {
                $view = view('orders.print.gift2_A4');
            }
        } else {
            $view = view('orders.print.sale_exhibition_A4');
        }
        return $view
            ->with(compact('order', 'orderBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price', 'total_discountable_price'));
    }

    public function add($client_id = null)
    {
        if (!empty($client_id)) {
            $client = Client::find($client_id);
            return view('orders.add_order')->with('client', $client);
        } else {
            $clients = Client::all();
            return view('orders.add_order')->with('clients', $clients);
        }

    }

    public function store(Request $request)
    {
        $client = explode(' # ', $request->client_id);
        $request->request->add(
            [
                'client_id' => $client[0],
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );
        //$request->request->set('client_id', $client[0]);
        //$request->request->set('created_by', Auth::user()->id);
        //$request->request->set('updated_by', Auth::user()->id);

        $validated = $request->validate([
            'type' => 'required|alpha',
            'client_id' => 'required|numeric|exists:clients,id',
            'created_by' => 'required|numeric|exists:users,id',
            'updated_by' => 'required|numeric|exists:users,id',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);
        $order = Order::Create($validated);
        return redirect(Route('editOrder', $order->id));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'paid_amount' => 'required|numeric',
        ]);

        //test if paid_amount > required_amount
        if ($request->paid_amount > $this->calculate($id)['total_purchase_price']) {
            $paidAmountAlert = "خطأ: لا يمكن أن يكون المبلغ المدفوع أكبر من المبلغ المستحق !";
            return redirect()->back()->with(compact('paidAmountAlert'));

        } else {
            $order = Order::find($id)->update($validated);
            $this->updateRequiredAmount($id);
            $this->updatedBy($id);

            return redirect(Route('editOrder', $id));
        }
    }


    public function edit($id)
    {
        $order = $this->calculate($id)['order'];
        $orderBooks = $this->calculate($id)['orderBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];
        $total_discountable_price = $this->calculate($id)['total_discountable_price'];

        //redirect if the seller try to access to gift orders
        if ($this->isSellerAndGift($id)) {
            return redirect()->route('ordersList');
        }

        return view('orders.edit_order')
            ->with(compact('order', 'orderBooks', 'orderBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price', 'total_discountable_price'));
    }

    public function storeBook($id, Request $request)
    {
        //get book info
        $book = explode(' # ', $request->book_id);
        $current_book = Book::find($book[0]);
        //add fields from DB
        $request->request->add(
            [
                'book_id' => $book[0],
                'order_id' => $id,
                'purchase_price' => $current_book->purchase_price,
                'sale_price' => $current_book->purchase_price + ($current_book->purchase_price * $current_book->sale_percentage / 100),
            ]
        );

        $validated = $request->validate([
            'order_id' => 'required|numeric|exists:orders,id',
            'book_id' => 'required|numeric|exists:books,id',
            'quantity' => 'required|numeric|min:1|max:' . $current_book->quantity,
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ]);

        OrderBook::Create($validated);
        $this->updateRequiredAmount($id);

        //updated by user
        $this->updatedBy($id);

        //decrement book stock
        $this->decrementStock($request->book_id, $request->quantity);

        return redirect(Route('editOrder', $id));
    }

    public function destroyBook($id, $book_id)
    {
        $order_book = OrderBook::where('order_id', $id)->where('book_id', $book_id)->first();

        //delete Book from order
        OrderBook::where('order_id', $id)->where('book_id', $book_id)->delete();
        $this->updateRequiredAmount($id);
        //updated by user
        $this->updatedBy($id);
        //increment book stock
        $this->incrementStock($book_id, $order_book->quantity);

        return redirect(Route('editOrder', $id));
    }

    public function destroy($id)
    {
        OrderBook::where('order_id', $id)->delete();
        Order::where('id', $id)->delete();
        return redirect(Route('ordersList'));
    }

    /******* SALE BY PIECES ******/
    public function showSale(Request $request)
    {
        $book_data = "";

        if ($request->filled('book_id', 'quantity')) {

            //get book info
            $book = explode(' # ', $request->book_id);
            $current_book = Book::find($book[0]);

            $book_data = array("book_id" => $book[0],
                "title" => $book[1],
                "quantity" => $request->quantity,
                "salePrice" => $current_book->purchase_price + ($current_book->purchase_price * $current_book->sale_percentage / 100),
                "totalSalePrice" => ($current_book->purchase_price + ($current_book->purchase_price * $current_book->sale_percentage / 100)) * $request->quantity);
        }

        return view('orders.sales.sale')
            ->with('book_data', $book_data);
    }


    public function updateStock(Request $request)
    {
        //get book info
        $currentBook = Book::find($request->book_id);

        $validated = $request->validate([
            'book_id' => 'required|numeric|exists:books,id',
            'quantity' => 'required|numeric|min:1|max:' . $currentBook->quantity,
        ]);

        //decrement book stock
        $currentBook->decrement('quantity', $request->quantity);

        $message = "تم بيع " . $request->quantity . " نسخ من كتاب: " . $currentBook->title;

        return view('orders.sales.sale')
            ->with('message', $message);
    }

    /******* TRASHED ORDERS *******/
    public function showTrashed()
    {
        $trashedOrders = Order::onlyTrashed()->paginate(15);
        return view('trash.orders')
            ->with(compact('trashedOrders'));
    }

    public function restoreTrashed($id)
    {
        $trashedOrderBook = OrderBook::onlyTrashed()->where('order_id', $id);
        $trashedOrder = Order::onlyTrashed()->find($id);

        $trashedOrderBook->restore();
        $trashedOrder->restore();
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        $trashedOrderBook = OrderBook::onlyTrashed()->where('order_id', $id);
        $trashedOrder = Order::onlyTrashed()->find($id);

        $trashedOrderBook->forceDelete();
        $trashedOrder->forceDelete();
        return redirect()->back();
    }
}
