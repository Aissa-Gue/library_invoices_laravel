<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'last_name',
        'first_name',
        'father_name',
        'establishment',
        'address',
        'phone1',
        'phone2'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class)->withTrashed();
    }
}
