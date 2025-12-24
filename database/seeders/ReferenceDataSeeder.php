<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceDataSeeder extends Seeder
{
    /**
     * Number of coats to create
     */
    private int $coatCount = 5;

    public function run(): void
    {
        // Load species and breeds from JSON files
        $speciesData = json_decode(file_get_contents(database_path('data/species.json')), true);
        $breedsData = json_decode(file_get_contents(database_path('data/breeds.json')), true);

        // Create species and breeds
        $breeds = [];

        foreach ($speciesData as $specieName) {
            $specie = Specie::create([
                'name' => $specieName,
            ]);

            // Prepare breeds for this specie
            if (isset($breedsData[$specieName])) {
                foreach ($breedsData[$specieName] as $breedName) {
                    $breeds[] = [
                        'name' => $breedName,
                        'specie_id' => $specie->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert all breeds
        if (!empty($breeds)) {
            Breed::insert($breeds);
        }

        // Create coats
        Coat::factory($this->coatCount)->create();
    }
}
