<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'created_by',
        'updated_by',
        'type',
        'discount_percentage',
        'paid_amount'
    ];

    // belongsTo => foreign key here
    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id')->withTrashed();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,'updated_by','id')->withTrashed();
    }

}
