<?php

namespace Database\Seeders;

use App\Enums\AnimalGender;
use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        // Load animals from JSON
        $animalsData = json_decode(file_get_contents(database_path('data/animals.json')), true);

        // Get all coats for random assignment
        $coats = Coat::all();

        foreach ($animalsData as $animalData) {
            // Find the specie
            $specie = Specie::where('name', $animalData['specie'])->first();

            if (! $specie) {
                continue; // Skip if specie not found
            }

            // Find the breed
            $breed = Breed::where('name', $animalData['breed'])
                ->where('specie_id', $specie->id)
                ->first();

            if (! $breed) {
                continue; // Skip if breed not found
            }

            // Create the animal
            Animal::create([
                'name' => $animalData['name'],
                'gender' => isset($animalData['gender']) ? AnimalGender::from($animalData['gender']) : null,
                'age' => $animalData['age'] ?? null,
                'description' => $animalData['description'] ?? null,
                'status' => AnimalStatus::from($animalData['status']),
                'published' => $animalData['published'] ?? true,
                'admission_date' => $animalData['admission_date'] ?? null,
                'specie_id' => $specie->id,
                'breed_id' => $breed->id,
                'coat_id' => $coats->random()->id,
            ]);
        }
    }
}
