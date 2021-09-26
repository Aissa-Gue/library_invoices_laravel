<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'father_name',
        'address',
        'phone1',
        'phone2'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'person_id', 'id')->withTrashed();
    }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'person_id', 'id')->withTrashed();
    }
}
