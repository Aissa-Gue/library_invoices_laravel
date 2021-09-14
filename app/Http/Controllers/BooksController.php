<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
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
            'investigator' => 'string',
            'translator' => 'string',
            'publisher' => 'string',
            'publication_year' => 'numeric',
            'edition' => 'string',
            'quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'discount' => 'required|numeric',
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
            'investigator' => 'string',
            'translator' => 'string',
            'publisher' => 'string',
            'publication_year' => 'numeric',
            'edition' => 'string',
            'quantity' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'discount' => 'required|numeric',
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

        return redirect(Route('booksList'))->with('success', 'All good!');
    }

    function exportExcel()
    {
        return Excel::download(new BooksExport, 'قائمة الكتب.xlsx');
    }

    /******* TRASHED BOOKS *******/
    public function showTrashed(){
        $trashedBooks = Book::onlyTrashed()->get();
        return view('trash.books')
            ->with(compact('trashedBooks'));
    }

    public function restoreTrashed($id){
        $trashedBook = Book::onlyTrashed()->find($id);
        $trashedBook->restore();
        return redirect()->back();
    }

    public function dropTrashed($id){
        $trashedBook = Book::onlyTrashed()->find($id);
        $trashedBook->forceDelete();
        return redirect()->back();
    }
}
