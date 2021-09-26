<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'investigator',
        'translator',
        'publisher',
        'publication_year',
        'edition',
        'quantity',
        'sale_percentage',
        'purchase_price',
        'discount',
    ];

    public function orders()
    {
        return $this->hasMany(OrderBook::class, 'book_id', 'id');
    }
}
