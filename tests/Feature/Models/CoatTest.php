<?php

use App\Models\Animal;
use App\Models\Coat;

beforeEach(function () {
    $this->coat = Coat::factory()->create();
});

test('coat has many animals', function () {
    Animal::factory(5)->create([
        'coat_id' => $this->coat->id,
    ]);

    expect($this->coat->animals)->toHaveCount(5);
});

test('coat can exist without animals', function () {
    expect($this->coat->animals)->toHaveCount(0);
});
