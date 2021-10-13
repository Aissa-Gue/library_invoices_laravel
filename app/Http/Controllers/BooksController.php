<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\OrderBook;
use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\Book;

class BooksController extends Controller
{
    public function showAllData(Request $request)
    {
        $title = $request->get('title');
        $author = $request->get('author');

        $books = Book::where('title', 'LIKE', '%' . $title . '%')
            ->where('author', 'LIKE', '%' . $author . '%')
            ->orderBy('title', 'ASC')
            ->paginate(15);

        return view('books.books_list')->with('books', $books);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.preview_book')->with('book', $book);
    }


    public function add()
    {
        return view('books.add_book');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:books',
            'author' => 'required',
            'investigator' => 'nullable|string',
            'translator' => 'nullable|string',
            'publisher' => 'nullable|string',
            'publication_year' => 'nullable|numeric',
            'edition' => 'nullable|string',
            //'quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_percentage' => 'required|numeric|in:0,10,15,20,25,30',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $book = Book::Create($validated);
        return redirect(Route('previewBook', $book->id));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit_book')->with('book', $book);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:books,title,' . $id,
            'author' => 'required',
            'investigator' => 'nullable|string',
            'translator' => 'nullable|string',
            'publisher' => 'nullable|string',
            'publication_year' => 'nullable|numeric',
            'edition' => 'nullable|string',
            //'quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_percentage' => 'required|numeric|in:0,10,15,20,25,30',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $book = Book::find($id)->Update($validated);
        return redirect(Route('previewBook', $id));
    }

    public function destroy($id)
    {
        Book::find($id)->delete();
        return redirect(Route('booksList'));
    }


    public function settingBooks()
    {
        return view('settings.books');
    }

    public function importExcel()
    {
        Excel::import(new BooksImport, request()->file('books_file'));

        $importBooksAlert = "تم استيراد قائمة الكتب بنجاح";
        return redirect()->back()->with(compact('importBooksAlert'));
    }

    function exportExcel()
    {
        return Excel::download(new BooksExport, 'قائمة الكتب.xlsx');
    }

    /******* TRASHED BOOKS *******/
    public function showTrashed()
    {
        $trashedBooks = Book::onlyTrashed()->paginate(15);
        return view('trash.books')
            ->with(compact('trashedBooks'));
    }

    public function restoreTrashed($id)
    {
        Book::where('id', $id)->restore();
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        //test if book exist in order
        $bookOrders = OrderBook::where('book_id', $id)->get();
        //test if book exist in sale
        $bookSales = Sale::where('book_id', $id)->get();

        if ($bookOrders->isEmpty() and $bookSales->isEmpty()) {
            Book::where('id', $id)->forceDelete();
            return redirect()->back();
        } else {
            $deleteProblem = 'لا يمكنك حذف الكتاب لوجود فواتير / مبيعات مرتبطة به';
            return redirect()->back()->with(compact('deleteProblem'));
        }
    }
}
