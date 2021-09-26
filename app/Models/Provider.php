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
        'person_id',
        'establishment'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class)->withTrashed();
    }
}
