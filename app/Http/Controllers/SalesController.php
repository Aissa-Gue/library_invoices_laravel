<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function incrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->increment('quantity', $quantity);
    }

    public function decrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->decrement('quantity', $quantity);
    }

    public function addSale(Request $request)
    {
        $title = $request->get('title');
        $created_at = $request->get('created_at');

        $sales = Sale::join('books', 'books.id', 'sales.book_id')
            ->WhereDate('sales.created_at', 'LIKE', '%' . $created_at . '%')
            ->where('title', 'LIKE', '%' . $title . '%')
            ->select('sales.id', 'title', 'created_by', 'sales.quantity', 'sales.sale_price', 'sales.created_at')
            ->orderBy('id', 'DESC')
            ->paginate(15);

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

        return view('sales.add_sale')
            ->with('book_data', $book_data)
            ->with(compact('sales'));
    }


    public function store(Request $request)
    {
        //get book info
        $currentBook = Book::find($request->book_id);
        //add fields from DB
        $request->request->add(
            [
                'sale_price' => $currentBook->purchase_price + ($currentBook->purchase_price * $currentBook->sale_percentage / 100),
                'created_by' => Auth::id()
            ]
        );
        $validated = $request->validate([
            'book_id' => 'required|numeric|exists:books,id',
            'quantity' => 'required|numeric|min:1|max:' . $currentBook->quantity,
            'sale_price' => 'required|numeric',
            'created_by' => 'required|numeric|exists:users,id',
        ]);

        DB::transaction(function () use ($request, $validated) {
            Sale::create($validated);
            $this->decrementStock($request->book_id, $request->quantity);
        });

        $message = "تم بيع " . $request->quantity . " نسخ من كتاب: " . $currentBook->title;
        return redirect()->route('addSale')->with('message', $message);
    }

    public function destroy($id)
    {
        $sale = Sale::find($id);

        DB::transaction(function () use ($id, $sale) {
            $this->incrementStock($sale->book_id, $sale->quantity);
            Sale::where('id', $id)->delete();
        });
        return redirect()->back();
    }

    /******* TRASHED SALES *******/
    public function showTrashed()
    {
        $trashedSales = Sale::onlyTrashed()->paginate(15);
        return view('trash.sales')
            ->with(compact('trashedSales'));
    }

    public function restoreTrashed($id)
    {
        $sale = Sale::withTrashed()->find($id);

        DB::transaction(function () use ($id, $sale) {
            $this->decrementStock($sale->book_id, $sale->quantity);
            Sale::where('id', $id)->restore();
        });
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        $sale = Sale::withTrashed()->find($id);

        DB::transaction(function () use ($id, $sale) {
            $this->incrementStock($sale->book_id, $sale->quantity);
            Sale::where('id', $id)->forceDelete();
        });
        return redirect()->back();
    }

}
