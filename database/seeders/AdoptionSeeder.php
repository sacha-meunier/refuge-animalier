<?php

namespace Database\Seeders;

use App\Models\Adoption;
use App\Models\Animal;
use Illuminate\Database\Seeder;

class AdoptionSeeder extends Seeder
{
    /**
     * Number of adoptions to create
     */
    private int $adoptionCount = 2;

    public function run(): void
    {
        // Adoptions will be created manually through the website interface
        // as they require specific contacts and animal associations

        // Get all animals
        // $animals = Animal::all();

        // Only create adoptions if we have enough animals
        // if ($animals->count() >= $this->adoptionCount) {
        //     $animals->random($this->adoptionCount)->each(function ($animal) {
        //         Adoption::factory()->create([
        //             'animal_id' => $animal->id,
        //         ]);
        //     });
        // }
    }
}
