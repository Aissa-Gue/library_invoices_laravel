<div>
    <input type="hidden" wire:model="order_id" value="{{$order_id}}">
    <input type="hidden" wire:model="purchase_id" value="{{$purchase_id}}">
    <input type="hidden" wire:model="isSaleByPieces" value="{{$isSaleByPieces}}">

    <input list="books" class="form-control" name="book_id" id="book_id"
           placeholder="أدخل عنوان الكتاب"
           wire:model="title" required>
    <datalist id="books">
        @foreach($books as $book)
            <option value="{{$book->id .' # '. $book->title}}">
        @endforeach
    </datalist>
</div>
