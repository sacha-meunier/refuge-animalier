<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breed extends Model
{
    protected $fillable = [
        'name',
        'specie_id',
    ];

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
