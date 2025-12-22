<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    use HasFactory;

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
        'specie_id',
        'breed_id',
        'user_id',
    ];

    protected $casts = [
        'age' => 'datetime',
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

    public function specie(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
