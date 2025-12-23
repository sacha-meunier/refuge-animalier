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
}
