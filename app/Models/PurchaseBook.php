<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseBook extends Model
{
    use HasFactory;
    use SoftDeletes;

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
