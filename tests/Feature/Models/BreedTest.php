<?php

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Specie;

beforeEach(function () {
    $this->specie = Specie::factory()->create();
    $this->breed = Breed::factory()->create([
        'specie_id' => $this->specie->id,
    ]);
});

test('breed belongs to specie', function () {
    expect($this->breed->specie)
        ->toBeInstanceOf(Specie::class)
        ->id->toBe($this->specie->id);
});

test('breed has many animals', function () {
    Animal::factory(3)->create([
        'breed_id' => $this->breed->id,
    ]);

    expect($this->breed->animals)->toHaveCount(3);
});

test('breed can exist without animals', function () {
    expect($this->breed->animals)->toHaveCount(0);
});

test('deleting specie automatically deletes related breeds', function () {
    $breedId = $this->breed->id;

    $this->specie->delete();

    expect(Breed::find($breedId))->toBeNull();
});
