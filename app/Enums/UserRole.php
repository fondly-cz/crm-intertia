<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrátor',
            self::MANAGER => 'Manažer',
        };
    }
}
