<?php

namespace Database\Factories;

use App\Enums\AdoptionStatus;
use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdoptionFactory extends Factory
{
    protected $model = Adoption::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->text(),
            'status' => fake()->randomElement(AdoptionStatus::cases()),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'contact_id' => Contact::factory(),
            'animal_id' => Animal::factory(),
        ];
    }
}
