<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculationItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_accepted' => 'boolean',
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'margin' => 'decimal:2',
        'parent_id' => 'integer',
        'payment_period' => \App\Enums\PaymentPeriod::class,
    ];

    public function calculation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function parent()
    {
        return $this->belongsTo(CalculationItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CalculationItem::class, 'parent_id');
    }
}
