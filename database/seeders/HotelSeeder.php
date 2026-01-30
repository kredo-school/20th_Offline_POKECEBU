<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
    [
        'name' => 'Ocean View Hotel',
        'description' => 'A beachfront hotel with stunning ocean views and modern rooms.',
        'address' => '123 Beach Road',
        'city' => 'Cebu City',
        'latitude' => 10.3157,
        'longitude' => 123.8854,
        'star_rating' => 5,
        'phone' => '+63-32-123-4567',
        'website' => 'https://oceanviewhotel.com',
    ],
    [
        'name' => 'City Central Hotel',
        'description' => 'Located in the heart of the city, ideal for business and leisure travelers.',
        'address' => '456 Downtown Avenue',
        'city' => 'Manila',
        'latitude' => 14.5995,
        'longitude' => 120.9842,
        'star_rating' => 4,
        'phone' => '+63-2-234-5678',
        'website' => 'https://citycentralhotel.ph',
    ],
    [
        'name' => 'Sunset Resort',
        'description' => 'A relaxing resort famous for its sunset views and swimming pools.',
        'address' => '88 Sunset Boulevard',
        'city' => 'Boracay',
        'latitude' => 11.9674,
        'longitude' => 121.9248,
        'star_rating' => 5,
        'phone' => '+63-36-345-6789',
        'website' => 'https://sunsetresortboracay.com',
    ],
    [
        'name' => 'Mountain Breeze Inn',
        'description' => 'A cozy inn near the mountains, perfect for a quiet getaway.',
        'address' => '12 Hilltop Street',
        'city' => 'Baguio',
        'latitude' => 16.4023,
        'longitude' => 120.5960,
        'star_rating' => 3,
        'phone' => '+63-74-456-7890',
        'website' => 'https://mountainbreezeinn.ph',
    ],
    [
        'name' => 'Green Leaf Lodge',
        'description' => 'An eco-friendly lodge surrounded by nature and fresh air.',
        'address' => '5 Forest Lane',
        'city' => 'Davao City',
        'latitude' => 7.1907,
        'longitude' => 125.4553,
        'star_rating' => 4,
        'phone' => '+63-82-567-8901',
        'website' => 'https://greenleaflodge.ph',
    ],
    ];


        Hotel::insert($hotels);
    }
}
