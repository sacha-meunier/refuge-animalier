<?php

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Note;
use App\Models\Specie;

beforeEach(function () {
    $this->specie = Specie::factory()->create();
    $this->breed = Breed::factory()->create(['specie_id' => $this->specie->id]);
    $this->coat = Coat::factory()->create();

    $this->animal = Animal::factory()->create([
        'specie_id' => $this->specie->id,
        'breed_id' => $this->breed->id,
        'coat_id' => $this->coat->id,
    ]);
});

test('animal belongs to specie', function () {
    expect($this->animal->specie->id)
        ->toBe($this->specie->id);
});

test('specie has many animals', function () {
    expect($this->specie->animals)->toHaveCount(1);
});

test('animal belongs to breed', function () {
    expect($this->animal->breed_id)
        ->toBe($this->breed->id);
});

test('animal belongs to coat', function () {
    expect($this->animal->coat->id)
        ->toBe($this->coat->id);
});

test('animal has many notes', function () {
    Note::factory(3)->create([
        'animal_id' => $this->animal->id,
    ]);

    expect($this->animal->notes)
        ->toHaveCount(3);
});
