<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSearchBar extends Component
{
    public $title;
    public $order_id;

    public function render()
    {
        $books = Book::where('id', 'LIKE', '%' . $this->title)
            ->Where('title', 'LIKE', '%' . $this->title . '%')
            ->whereNotIn('books.id', function ($query) {
                $query->select('book_id')
                    ->from('order__books AS ob')
                    ->where('ob.order_id', $this->order_id);
            })->paginate(10);

        /*
        $existBooks = Order_Book::pluck('book_id')->all();
        $books = Book::whereNotIn('id', $existBooks)
            ->where('id', 'LIKE', '%' . $this->title)
            ->Where('title', 'LIKE', '%' . $this->title . '%')
            ->paginate(10);
        */

        return view('livewire.book-search-bar')
            ->with('books', $books);
    }
}
