<?php

namespace Database\Factories;

use App\Enums\AdoptionStatus;
use App\Models\Adoption;
use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdoptionFactory extends Factory
{
    protected $model = Adoption::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'content' => $this->faker->text(),
            'status' => fake()->randomElement(AdoptionStatus::cases()),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'animal_id' => Animal::factory(),
        ];
    }
}
