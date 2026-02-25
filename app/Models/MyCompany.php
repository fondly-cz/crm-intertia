<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyCompany extends Model
{
    protected $fillable = [
        'name',
        'ico',
        'dic',
        'address',
        'city',
        'postal_code',
        'country',
        'email',
        'phone',
        'website',
        'bank_account',
    ];
}
