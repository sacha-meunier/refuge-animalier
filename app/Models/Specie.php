<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specie extends Model
{
    protected $fillable = [
        'name',
    ];

    public function races(): HasMany
    {
        return $this->hasMany(Breed::class);
    }

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
