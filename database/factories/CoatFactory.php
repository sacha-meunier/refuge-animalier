<?php

namespace Database\Factories;

use App\Models\Coat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CoatFactory extends Factory
{
    protected $model = Coat::class;

    private static ?array $coatNames = null;

    public function definition(): array
    {
        if (self::$coatNames === null) {
            $jsonPath = database_path('data/coats.json');
            self::$coatNames = json_decode(file_get_contents($jsonPath), true);
        }

        return [
            'name' => $this->faker->randomElement(self::$coatNames),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
