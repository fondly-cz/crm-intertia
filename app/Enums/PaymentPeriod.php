<?php

namespace App\Enums;

enum PaymentPeriod: string
{
    case ONCE = 'once';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::ONCE => 'Jednorázově',
            self::MONTHLY => 'Měsíčně',
            self::YEARLY => 'Ročně',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::ONCE => 'bg-gray-100 text-gray-600',
            self::MONTHLY => 'bg-blue-100 text-blue-600',
            self::YEARLY => 'bg-purple-100 text-purple-600',
        };
    }
}
