<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderBook extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'purchase_price',
        'sale_price'
    ];

    // belongsTo => foreign key here
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->withTrashed();
    }
}
