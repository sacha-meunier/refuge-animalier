<?php

namespace App\Models;

use App\Enums\AdoptionStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adoption extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'animal_id',
        'contact_id'
    ];

    protected $casts = [
        'status' => AdoptionStatus::class,
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans() ?? __('dates.not_available'),
        );
    }
}
