<?php

namespace App\Enums;

enum AnimalStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case VALIDATED = 'validated';
    case ADOPTED = 'adopted';
    case IN_CARE = 'in_care';
    // case available = 'available';
    // case RESERVED = 'reserved';

    public function label(): string
    {
        return match ($this) {
            self::IN_PROGRESS => __('statuses.animals.in_progress'),
            self::VALIDATED => __('statuses.animals.validated'),
            self::ADOPTED => __('statuses.animals.adopted'),
            self::IN_CARE => __('statuses.animals.in_care'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'bg-badge-neutral text-badge-neutral-foreground',
            self::VALIDATED => 'bg-badge-info text-badge-info-foreground',
            self::ADOPTED => 'bg-badge-success text-badge-success-foreground',
            self::IN_CARE => 'bg-badge-warning text-badge-warning-foreground',
        };
    }
}
