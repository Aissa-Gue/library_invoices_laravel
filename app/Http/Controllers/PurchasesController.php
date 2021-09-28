<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Provider;
use App\Models\Person;
use App\Models\Purchase;
use App\Models\PurchaseBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public function calculate($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchaseBooks = PurchaseBook::where('purchase_id', $id)->get();

        $books = PurchaseBook::Join("books", function ($join) {
            $join->on("books.id", "=", "purchase_books.book_id");
        })
            ->select(DB::raw('sum(purchase_books.quantity * purchase_books.purchase_price) As purchase_price_sum'),
                DB::raw('sum(purchase_books.quantity * (purchase_books.purchase_price + purchase_books.purchase_price * books.sale_percentage / 100)) As sale_price_sum'),
                DB::raw('sum(purchase_books.quantity) As quantity'))
            ->where("purchase_books.purchase_id", "=", $id)
            ->groupBy("purchase_books.purchase_id")
            ->first();


        if (!empty($books)) {
            $total_quantity = $books->quantity;
            $total_purchase_price = $books->purchase_price_sum;
            $total_sale_price = $books->sale_price_sum;
        } else {
            $total_quantity = 0;
            $total_purchase_price = 0;
            $total_sale_price = 0;
        }


        return compact(
            'purchase',
            'purchaseBooks',
            'total_quantity',
            'total_purchase_price',
            'total_sale_price'
        );
    }

    public function updateRequiredAmount($id)
    {
        $this->calculate($id);
        Purchase::where('id', $id)->update(['required_amount' => $this->calculate($id)['total_purchase_price']]);
    }

    public function updatedBy($id)
    {
        Purchase::where('id', $id)->update(['updated_by' => Auth::user()->id]);
    }

    public function incrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->increment('quantity', $quantity);
    }

    public function decrementStock($book_id, $quantity)
    {
        Book::where('id', $book_id)->decrement('quantity', $quantity);
    }

    public function updateBookPrice($book_id, $purchase_price)
    {
        Book::where('id', $book_id)
            ->update(['purchase_price' => $purchase_price]);
    }

    public function updateSalePercentage($id, Request $request)
    {
        $validated = $request->validate([
            'sale_percentage' => 'required|numeric|in:0,10,15,20,25,30'
        ]);

        $book = Book::where('id', $id)->first();
        $book->update($validated);
        $percentageAlert = "تم تعديل نسبة بيع الكتاب إلى: " . $request->sale_percentage . "% ، وسعر الشراء إلى: " . number_format($book->purchase_price, 2) . " بنجاح";
        return redirect()->back()->with(compact('percentageAlert'));
    }

    public function purchasePriceAlert($id)
    {
        $book = Book::join('purchase_books', 'purchase_books.book_id', 'books.id')
            ->where('purchase_id', $id)
            ->select('books.purchase_price')
            ->first();

        $purchasePriceAlert = "تم تعديل سعر شراء الكتاب إلى: " . number_format($book->purchase_price, 2) . " بنجاح";
        return redirect()->back()->with(compact('purchasePriceAlert'));
    }

    public function deleteEmptyPurchases()
    {
        Purchase::withTrashed()
            ->leftjoin('purchase_books', 'purchase_books.purchase_id', 'purchases.id')
            ->where('purchase_id', null)
            ->whereDate('purchases.updated_at', '<', Carbon::today())
            ->forceDelete();
    }

    public function showAllData(Request $request)
    {
        $lname = $request->get('last_name');
        $fname = $request->get('first_name');
        $establishment = $request->get('establishment');
        $purchase_id = $request->get('purchase_id');

        $purchases = Purchase::join('providers', 'providers.person_id', 'purchases.provider_id')
            ->join('people', 'people.id', 'providers.person_id')
            ->where('last_name', 'LIKE', '%' . $lname . '%')
            ->where('first_name', 'LIKE', '%' . $fname . '%')
            ->where(function ($query) use ($establishment) {
                $query->where('establishment', 'LIKE', '%' . $establishment . '%')
                    ->orWhere('establishment', '=', null);
            })
            ->where('purchases.id', 'LIKE', '%' . $purchase_id)
            ->select('purchases.id', 'purchases.required_amount', 'purchases.paid_amount', 'purchases.created_at', 'last_name', 'first_name', 'father_name', 'establishment')
            ->orderBy('purchases.created_at', 'DESC')
            ->paginate(15);

        return view('purchases.purchases_list')->with('purchases', $purchases);
    }

    public function show($id)
    {
        $purchase = $this->calculate($id)['purchase'];
        $purchaseBooks = $this->calculate($id)['purchaseBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];

        return view('purchases.preview_purchase')
            ->with(compact('purchase', 'purchaseBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price'));
    }

    public function add($provider_id = null)
    {
        if (!empty($provider_id)) {
            $provider = Person::join('providers', 'providers.person_id', 'people.id')->where('person_id', $provider_id)->first();
            return view('purchases.add_purchase')->with('provider', $provider);
        } else {
            return view('purchases.add_purchase');
        }
    }

    public function store(Request $request)
    {
        $provider = explode(' # ', $request->provider_id);
        $request->request->add(
            [
                'provider_id' => $provider[0],
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        $validated = $request->validate([
            'provider_id' => 'required|numeric|exists:providers,person_id',
            'created_by' => 'required|numeric|exists:users,id',
            'updated_by' => 'required|numeric|exists:users,id',
        ]);

        $purchase = Purchase::Create($validated);
        return redirect(Route('editPurchase', $purchase->id));
    }

    public function edit($id)
    {
        $purchase = $this->calculate($id)['purchase'];
        $purchaseBooks = $this->calculate($id)['purchaseBooks'];
        $total_quantity = $this->calculate($id)['total_quantity'];
        $total_purchase_price = $this->calculate($id)['total_purchase_price'];
        $total_sale_price = $this->calculate($id)['total_sale_price'];

        return view('purchases.edit_purchase')
            ->with(compact('purchase', 'purchaseBooks', 'purchaseBooks', 'total_quantity', 'total_purchase_price', 'total_sale_price'));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'paid_amount' => 'required|numeric',
        ]);

        //test if paid_amount > required_amount
        if ($request->paid_amount > $this->calculate($id)['total_purchase_price']) {
            $paidAmountAlert = "خطأ: لا يمكن أن يكون المبلغ المدفوع أكبر من المبلغ المستحق !";
            return redirect()->back()->with(compact('paidAmountAlert'));

        } else {
            DB::transaction(function () use ($validated, $id) {
                Purchase::find($id)->update($validated);
                $this->updateRequiredAmount($id);
                $this->updatedBy($id);
            });
            return redirect(Route('editPurchase', $id));
        }
    }

    public function storeBook($id, Request $request)
    {
        //get book info
        $book = explode(' # ', $request->book_id);
        $Current_book = Book::find($book[0]);
        //add fields from DB
        $request->request->add(
            [
                'purchase_id' => $id,
                'book_id' => $book[0],
            ]
        );

        $validated = $request->validate([
            'purchase_id' => 'required|numeric|exists:purchases,id',
            'book_id' => 'required|numeric|exists:books,id',
            'quantity' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric',
        ]);
        //old book info [before update]
        $oldBookInfo = Book::find($request->book_id);

        DB::transaction(function () use ($id, $validated, $request) {
            //add Book to purchases [purchase_books]
            PurchaseBook::Create($validated);
            //update required amount [purchases]
            $this->updateRequiredAmount($id);
            //updated by user [purchases]
            $this->updatedBy($id);
            //increment book stock [books]
            $this->incrementStock($request->book_id, $request->quantity);
            //update book price [books]
            $this->updateBookPrice($request->book_id, $request->purchase_price);
        });

        //check price
        if ($oldBookInfo->purchase_price == $request->purchase_price) {
            return redirect(Route('editPurchase', $id));
        } else {
            $priceAlert = 'انتبه: السعر القديم للكتاب لا ينطبق مع السعر الذي أدخلته !';
            $bookId = $oldBookInfo->id;
            $title = $oldBookInfo->title;
            $oldSalePercentage = $oldBookInfo->sale_percentage;
            $oldPurchasePrice = $oldBookInfo->purchase_price;
            $oldSalePrice = ($oldBookInfo->purchase_price + $oldBookInfo->purchase_price * $oldBookInfo->sale_percentage / 100);

            return redirect()->back()
                ->with(compact(
                        'priceAlert',
                        'bookId',
                        'title',
                        'oldSalePercentage',
                        'oldPurchasePrice',
                        'oldSalePrice'
                    )
                );
        }
    }

    public function destroyBook($id, $book_id)
    {
        $purchase_book = PurchaseBook::where('purchase_id', $id)->where('book_id', $book_id)->first();

        DB::transaction(function () use ($id, $purchase_book, $book_id) {
            //decrement book stock [books]
            $this->decrementStock($book_id, $purchase_book->quantity);
            //delete Book from purchase [purchase_books]
            PurchaseBook::where('purchase_id', $id)->where('book_id', $book_id)->forceDelete();
            //update required amount [purchases]
            $this->updateRequiredAmount($id);
            //updated by user [purchases]
            $this->updatedBy($id);
        });

        return redirect(Route('editPurchase', $id));
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            //delete all books from purchase [purchase_books]
            PurchaseBook::where('purchase_id', $id)->delete();
            //delete purchase [purchases]
            Purchase::where('id', $id)->delete();
        });
        return redirect(Route('purchasesList'));
    }


    /******* TRASHED PURCHASES *******/
    public function showTrashed()
    {
        $trashedPurchases = Purchase::onlyTrashed()->paginate(15);
        return view('trash.purchases')
            ->with(compact('trashedPurchases'));
    }

    public function restoreTrashed($id)
    {
        DB::transaction(function () use ($id) {
            PurchaseBook::where('purchase_id', $id)->restore();
            Purchase::where('id', $id)->restore();
        });
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        DB::transaction(function () use ($id) {
            PurchaseBook::where('purchase_id', $id)->forceDelete();
            Purchase::where('id', $id)->forceDelete();
        });
        return redirect()->back();
    }
}
