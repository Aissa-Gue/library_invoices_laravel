<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSearchBar extends Component
{
    public $title;
    public $order_id;
    public $purchase_id;
    public $isSaleByPieces;

    public function render()
    {
        if (!empty($this->order_id) or $this->isSaleByPieces == true) {
            $books = Book::where('id', 'LIKE', '%' . $this->title)
                ->Where('title', 'LIKE', '%' . $this->title . '%')
                ->where('quantity', '>', 0)
                ->whereNotIn('books.id', function ($query) {
                    $query->select('book_id')
                        ->from('order_books AS ob')
                        ->where('ob.order_id', $this->order_id);
                })->paginate(15);
        } elseif (!empty($this->purchase_id)) {
            $books = Book::where('id', 'LIKE', '%' . $this->title)
                ->Where('title', 'LIKE', '%' . $this->title . '%')
                ->where('quantity', '>=', 0)
                ->whereNotIn('books.id', function ($query) {
                    $query->select('book_id')
                        ->from('purchase_books AS pb')
                        ->where('pb.purchase_id', $this->purchase_id);
                })->paginate(15);
        }

        /*
        $existBooks = OrderBook::pluck('book_id')->all();
        $books = Book::whereNotIn('id', $existBooks)
            ->where('id', 'LIKE', '%' . $this->title)
            ->Where('title', 'LIKE', '%' . $this->title . '%')
            ->paginate(10);
        */

        return view('livewire.book-search-bar')
            ->with('books', $books);
    }
}