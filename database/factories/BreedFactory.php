<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BreedFactory extends Factory
{
    protected $model = Breed::class;

    private static ?array $breedsData = null;

    public function definition(): array
    {
        if (self::$breedsData === null) {
            $jsonPath = database_path('data/breeds.json');
            self::$breedsData = json_decode(file_get_contents($jsonPath), true);
        }

        // Get all breeds from all species
        $allBreeds = [];
        foreach (self::$breedsData as $breeds) {
            $allBreeds = array_merge($allBreeds, $breeds);
        }

        return [
            'name' => $this->faker->randomElement($allBreeds),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'specie_id' => Specie::factory(),
        ];
    }
}
