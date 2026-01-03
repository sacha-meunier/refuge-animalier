<?php

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Specie;

beforeEach(function () {
    $this->specie = Specie::factory()->create();
});

test('specie has many breeds', function () {
    Breed::factory(3)->create([
        'specie_id' => $this->specie->id,
    ]);

    expect($this->specie->breeds)->toHaveCount(3);
});

test('specie has many animals', function () {
    Animal::factory(3)->create([
        'specie_id' => $this->specie->id,
    ]);

    expect($this->specie->animals)->toHaveCount(3);
});

test('specie can have both breeds and animals', function () {
    Breed::factory(2)->create([
        'specie_id' => $this->specie->id,
    ]);
    Animal::factory(3)->create([
        'specie_id' => $this->specie->id,
    ]);

    expect($this->specie->breeds)
        ->toHaveCount(2)
        ->and($this->specie->animals)
        ->toHaveCount(3);
});
