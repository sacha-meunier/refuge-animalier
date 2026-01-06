<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        /*User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => UserRole::ADMIN,
            'password' => 'admin',
        ]);*/

        // Create Volunteer
        /*User::factory()->create([
            'name' => 'Volunteer',
            'email' => 'volunteer@volunteer.com',
            'role' => UserRole::VOLUNTEER,
            'password' => 'volunteer',
        ]);*/

        // Create Elise (Admin)
        User::create([
            'name' => 'Elise',
            'email' => 'elise@refuge.com',
            'email_verified_at' => now(),
            'role' => UserRole::ADMIN,
            'password' => Hash::make('examTECGpw2526'),
        ]);

        // Create Thomas (Volunteer)
        User::create([
            'name' => 'Thomas',
            'email' => 'thomas@refuge.com',
            'email_verified_at' => now(),
            'role' => UserRole::VOLUNTEER,
            'password' => Hash::make('examTECGpw2526'),
        ]);
    }
}
