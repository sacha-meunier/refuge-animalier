<?php

namespace App\Enums;

enum MessageType: string
{
    case CONTACT = 'contact';
    case VOLUNTEERING = 'volunteering';

    public function label(): string
    {
        return match ($this) {
            self::CONTACT => 'Contact',
            self::VOLUNTEERING => 'Volunteering',
        };
    }
}
