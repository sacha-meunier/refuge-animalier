<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adoption extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'content',
        'animal_id'
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans() ?? __('dates.not_available'),
        );
    }
}
