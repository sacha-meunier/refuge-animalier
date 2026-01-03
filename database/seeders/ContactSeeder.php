<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        // Load contacts from JSON
        $contactsData = json_decode(file_get_contents(database_path('data/contacts.json')), true);

        foreach ($contactsData as $contactData) {
            Contact::create([
                'name' => $contactData['name'],
                'email' => $contactData['email'],
                'phone' => $contactData['phone'],
            ]);
        }
    }
}
