<?php

namespace Database\Factories;

use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SpecieFactory extends Factory
{
    protected $model = Specie::class;

    private static ?array $specieNames = null;

    public function definition(): array
    {
        if (self::$specieNames === null) {
            $jsonPath = database_path('data/species.json');
            self::$specieNames = json_decode(file_get_contents($jsonPath), true);
        }

        return [
            'name' => $this->faker->randomElement(self::$specieNames),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
