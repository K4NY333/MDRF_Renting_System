<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

             User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),  // Don't forget to hash the password
            'role' => 'admin',  // Set the role as admin
            'contact_number' => '09123456789',  // Optional, add a contact number
            'image_path' => 'admin.jpg'
        ]);
    }
}
