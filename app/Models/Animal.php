<?php

namespace App\Models;

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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
    ];

    protected $casts = [
        'age' => 'datetime',
        'admission_date' => 'datetime',
        'pictures' => 'array',
        'published' => 'boolean',
        'gender' => AnimalGender::class,
        'status' => AnimalStatus::class,
    ];

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

    public function formattedAge(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->age?->diffForHumans(['parts' => 1, 'join' => true, 'syntax' => true]),
        );
    }

    protected function formattedAdmissionDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->admission_date?->diffForHumans(),
        );
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImageUrl('original'),
        );
    }

    public function imageThumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImageUrl('thumbnail'),
        );
    }

    public function imageMediumUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImageUrl('medium'),
        );
    }

    private function getImageUrl(string $variant = 'original'): ?string
    {
        if (! $this->pictures || empty($this->pictures)) {
            return null;
        }

        $filename = $this->pictures[0]['filename'] ?? null;
        if (! $filename) {
            return null;
        }

        $config = config('image.animals');
        $variantConfig = $config['variants'][$variant] ?? $config['original'];

        return Storage::disk('animals')->url(
            $variantConfig['path'] . '/' . $filename . '.webp'
        );
    }
}
