<?php

use App\Models\Animal;
use App\Models\Note;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->animal = Animal::factory()->create();
    $this->note = Note::factory()->create([
        'user_id' => $this->user->id,
        'animal_id' => $this->animal->id,
    ]);
});

test('note belongs to user', function () {
    expect($this->note->user->id)
        ->toBe($this->user->id);
});

test('note belongs to animal', function () {
    expect($this->note->animal->id)
        ->toBe($this->animal->id);
});
