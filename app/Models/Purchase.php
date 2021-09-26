<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'provider_id',
        'created_by',
        'updated_by',
        'paid_amount'
    ];

    // belongsTo => foreign key here
    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','person_id')->withTrashed();
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
