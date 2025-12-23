<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case VOLUNTEER = 'volunteer';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => __('roles.admin'),
            self::VOLUNTEER => __('roles.volunteer'),
        };
    }
}
