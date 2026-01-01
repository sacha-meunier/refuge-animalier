<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case VALIDATED = 'validated';
    case ADOPTED = 'adopted';
    // case available = 'available';
    // case IN_CARE = 'in_care';
    // case RESERVED = 'reserved';

    public function label(): string
    {
        return match ($this) {
            self::IN_PROGRESS => __('statuses.animals.in_progress'),
            self::VALIDATED => __('statuses.animals.validated'),
            self::ADOPTED => __('statuses.animals.adopted'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'bg-badge-neutral text-badge-neutral-foreground',
            self::VALIDATED => 'bg-badge-info text-badge-info-foreground',
            self::ADOPTED => 'bg-badge-success text-badge-success-foreground',
        };
    }
}
