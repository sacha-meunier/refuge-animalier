<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),

            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => Carbon::now(),

            'animal_id' => Animal::factory(),
            'user_id' => User::factory(),
        ];
    }
}
