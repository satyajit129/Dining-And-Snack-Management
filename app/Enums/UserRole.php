<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case USER = 2;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }

    public static function fromValue(int $value): self
    {
        return match ($value) {
            self::ADMIN->value => self::ADMIN,
            self::USER->value => self::USER,
            default => throw new \InvalidArgumentException('Invalid role value'),
        };
    }
}
