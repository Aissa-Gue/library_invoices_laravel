<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'book_id',
        'quantity',
        'purchase_price'
    ];

    // belongsTo => foreign key here
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id')->withTrashed();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id')->withTrashed();
    }
}
