<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'type',
        'message',
        'contact_id',
    ];

    protected $casts = [
        'type' => MessageType::class,
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans() ?? __('dates.not_available'),
        );
    }
}
