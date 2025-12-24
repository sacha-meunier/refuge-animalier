<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Number of random users to create
     */
    private int $randomUserCount = 5;

    public function run(): void
    {
        // Create Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => UserRole::ADMIN,
            'password' => 'admin',
        ]);

        // Create Volunteer
        User::factory()->create([
            'name' => 'Volunteer',
            'email' => 'volunteer@volunteer.com',
            'role' => UserRole::VOLUNTEER,
            'password' => 'volunteer',
        ]);

        // Create Random Users
        User::factory($this->randomUserCount)->create();
    }
}
