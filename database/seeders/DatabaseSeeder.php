<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Volunteer',
            'email' => 'volunteer@volunteer.com',
            'role' => 'volunteer',
            'password' => 'volunteer',
        ]);
    }
}
