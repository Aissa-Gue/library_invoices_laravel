<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'last_name',
        'first_name',
        'father_name',
        'address',
        'phone1',
        'phone2'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class)->withTrashed();
    }
}
