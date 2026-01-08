<?php

namespace App\Enums;

enum UserRole: string
{
    case VOLUNTEER = 'volunteer';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::VOLUNTEER => __('roles.volunteer'),
            self::ADMIN => __('roles.admin'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::VOLUNTEER => 'bg-badge-neutral text-badge-neutral-foreground',
            self::ADMIN => 'bg-badge-info text-badge-info-foreground',
        };
    }
}
