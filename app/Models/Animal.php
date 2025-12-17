<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'age',
        'description',
        'status',
        'pictures',
        'published',
        'admission_date',
        'coat_id',
        'note_id',
        'specie_id',
        'race_id',
        'user_id',
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'pictures' => 'array',
        'published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coat(): BelongsTo
    {
        return $this->belongsTo(Coat::class);
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function race(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
