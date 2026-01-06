<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Number of animals that will have notes
     */
    private int $animalsWithNotesCount = 5;

    /**
     * Minimum number of notes per animal
     */
    private int $minNotesPerAnimal = 0;

    /**
     * Maximum number of notes per animal
     */
    private int $maxNotesPerAnimal = 2;

    public function run(): void
    {
        // Notes will be created manually through the website interface
        // See database/data/notes_examples.json for inspiration

        // Get all animals and users
        // $animals = Animal::all();
        // $users = User::all();

        // Select random animals and create notes for them
        // $animals
        //     ->random(min($this->animalsWithNotesCount, $animals->count()))
        //     ->each(function ($animal) use ($users) {
        //         // Each selected animal gets a random number of notes
        //         $noteCount = rand($this->minNotesPerAnimal, $this->maxNotesPerAnimal);

        //         for ($i = 0; $i < $noteCount; $i++) {
        //             Note::factory()->create([
        //                 'animal_id' => $animal->id,
        //                 'user_id' => $users->random()->id,
        //             ]);
        //         }
        //     });
    }
}
