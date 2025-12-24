<?php

namespace App\Enums;

enum AdoptionStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case VALIDATED = 'validated';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => __('statuses.adoptions.pending'),
            self::IN_PROGRESS => __('statuses.adoptions.in_progress'),
            self::VALIDATED => __('statuses.adoptions.validated'),
            self::REJECTED => __('statuses.adoptions.rejected'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'bg-badge-warning text-badge-warning-foreground',
            self::IN_PROGRESS => 'bg-badge-info text-badge-info-foreground',
            self::VALIDATED => 'bg-badge-success text-badge-success-foreground',
            self::REJECTED => 'bg-badge-danger text-badge-danger-foreground',
        };
    }
}
