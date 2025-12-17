<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case VALIDATED = 'validated';
    case IN_PROGRESS = 'in_progress';
    case ADOPTED = 'adopted';
    //case available = 'available';
    //case IN_CARE = 'in_care';
    //case RESERVED = 'reserved';

    public function label(): string
    {
        return match($this) {
            self::VALIDATED => 'Validated',
            self::IN_PROGRESS => 'In progress',
            self::ADOPTED => 'Adopted',
        };
    }
}
