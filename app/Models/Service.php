<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'cost' => 'decimal:2',
        'margin' => 'decimal:2',
        'payment_period' => \App\Enums\PaymentPeriod::class,
    ];

    public function getPriceAttribute(): float
    {
        return $this->cost * (1 + $this->margin / 100);
    }
}
