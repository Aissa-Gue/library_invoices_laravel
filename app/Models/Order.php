<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'type',
        'discount_percentage',
        'paid_amount'
    ];

    // belongsTo => foreign key here
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
