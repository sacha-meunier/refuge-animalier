<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BreedFactory extends Factory
{
    protected $model = Breed::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'specie_id' => Specie::factory(),
        ];
    }

}
