<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Place;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TestingOwnerSeeder extends Seeder
{
    
        public function run()
    {
        // Create Owner
        $owner = User::create([
            'name' => 'John Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'contact_number' => '09171234567',
            'image_path' => 'images/users/owner.jpg',
        ]);

        // Create Place for Owner
        $place = Place::create([
            'user_id' => $owner->id,
            'name' => 'Sunrise Apartments',
            'description' => 'A cozy apartment complex in the city center.',
            'location' => '123 Main St, Cityville',
            'type' => 'apartment',
            'image_path' => 'images/places/sunrise.jpg',
        ]);

        // Create 3 Room Types
        $roomTypes = ['bedspacer', 'private', 'shared'];
        foreach ($roomTypes as $index => $type) {
            Room::create([
                'place_id' => $place->id,
                'name' => ucfirst($type) . " Room " . ($index + 1),
                'type' => $type,
                'capacity' => 2 + $index,
                'price' => 1500 + ($index * 500),
            ]);
        }
    }
    
    
}
