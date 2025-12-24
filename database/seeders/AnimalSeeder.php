<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Number of animals to create
     */
    private int $animalCount = 10;

    public function run(): void
    {
        // Get coats
        $coats = Coat::all();

        // Get random breeds
        $randomBreeds = Breed::inRandomOrder()
            ->limit(min($this->animalCount, Breed::count()))
            ->get();

        // Create animals
        foreach ($randomBreeds as $breed) {
            Animal::factory()->create([
                'breed_id' => $breed->id,
                'specie_id' => $breed->specie_id,
                'coat_id' => $coats->random()->id,
            ]);
        }
    }
}
