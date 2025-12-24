<?php

use App\Enums\AdoptionStatus;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
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

    $this->adoption = Adoption::factory()->create([
        'animal_id' => $this->animal->id,
    ]);
});

test('adoption belongs to animal', function () {
    expect($this->adoption->animal->id)->toBe($this->animal->id);
});

test('adoption can be updated', function () {
    $newStatus = AdoptionStatus::VALIDATED;
    $this->adoption->update(['status' => $newStatus]);

    expect($this->adoption->refresh()->status)->toBe($newStatus);
});

test('adoption can be deleted', function () {
    $adoptionId = $this->adoption->id;
    $this->adoption->delete();

    expect(Adoption::find($adoptionId))->toBeNull();
});
