<?php

namespace Database\Seeders;

use App\Models\Adoption;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Note;
use App\Models\Specie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Create Users (admin, volunteer and random users)
        |--------------------------------------------------------------------------
        */
        // Create Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => 'admin',
        ]);
        // Create Volunteer
        User::factory()->create([
            'name' => 'Volunteer',
            'email' => 'volunteer@volunteer.com',
            'role' => 'volunteer',
            'password' => 'volunteer',
        ]);
        // Create Random Users
        User::factory(5)->create();

        /*
        |--------------------------------------------------------------------------
        | Create Coats
        |--------------------------------------------------------------------------
        */
        $coats = Coat::factory(5)->create();

        /*
        |--------------------------------------------------------------------------
        | Create Species and Breeds
        |--------------------------------------------------------------------------
        */
        // Load species and breeds from JSON files
        $speciesData = json_decode(file_get_contents(database_path('data/species.json')), true);
        $breedsData = json_decode(file_get_contents(database_path('data/breeds.json')), true);

        // Create species from JSON only
        $species = collect();
        foreach ($speciesData as $specieName) {
            $specie = Specie::create(['name' => $specieName]);
            $species->push($specie);

            // Create breeds for this specie from JSON only
            if (isset($breedsData[$specieName])) {
                foreach ($breedsData[$specieName] as $breedName) {
                    Breed::create([
                        'name' => $breedName,
                        'specie_id' => $specie->id,
                    ]);
                }
            }
        }

        // Create a few animals (not for all breeds, only random ones)
        $breeds = Breed::all();
        $randomBreeds = $breeds->random(min(10, $breeds->count()));

        foreach ($randomBreeds as $breed) {
            Animal::factory(1)->create([
                'breed_id' => $breed->id,
                'specie_id' => $breed->specie_id,
                'coat_id' => $coats->random()->id,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Adoptions
        |--------------------------------------------------------------------------
        */
        // Create adoptions with existing animals
        $animals = Animal::all();
        if ($animals->count() >= 2) {
            $animals->random(2)->each(function ($animal) {
                Adoption::factory()->create([
                    'animal_id' => $animal->id,
                ]);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Create Notes
        |--------------------------------------------------------------------------
        */
        // Create notes for some animals only
        $animals = Animal::all();
        $users = User::all();

        $animals
            ->random(min(5, $animals->count()))
            ->each(function ($animal) use ($users) {
            // Each selected animal gets 1 or 2 notes
            $noteCount = rand(0, 2);

            for ($i = 0; $i < $noteCount; $i++) {
                Note::factory()->create([
                    'animal_id' => $animal->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        });
    }
}
