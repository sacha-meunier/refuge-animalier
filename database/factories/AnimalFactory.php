<?php

namespace Database\Factories;

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'gender' => fake()->randomElement(AnimalGender::cases()),
            'age' => $this->faker->dateTimeThisDecade(),
            'description' => $this->faker->text(),
            'status' => fake()->randomElement(AnimalStatus::cases()),
            'published' => $this->faker->boolean(80),
            'admission_date' => $this->faker->dateTimeThisYear,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'coat_id' => Coat::factory(),
            'specie_id' => Specie::factory(),
            'breed_id' => Breed::factory(),
        ];
    }
}
