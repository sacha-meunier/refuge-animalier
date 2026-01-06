<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function adoptions(): HasMany
    {
        return $this->hasMany(Adoption::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans() ?? __('dates.not_available'),
        );
    }
}
