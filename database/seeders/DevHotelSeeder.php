<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\HotelRoom;
use App\Models\HotelReservation;

class DevHotelSeeder extends Seeder
{
    public function run()
    {
        $h = Hotel::create([
            'name' => 'Sample Hotel',
            'description' => 'Dev sample hotel',
            'address' => '123 Test St',
            'city' => 'Cebu City',
            'latitude' => 10.3157,
            'longitude' => 123.8854,
            'star_rating' => 4.5,
            'phone' => '+63 32 123 4567',
            'website' => 'https://example.local'
        ]);

        $h->hotelImages()->create(['image' => 'placeholder-hotel.png']);

        $room = $h->rooms()->create([
            'type_id' => 1,
            'floor_number' => 1,
            'max_guests' => 2,
            'charges' => 2500,
            'status_id' => 1
        ]);

        HotelReservation::create([
            'user_id' => 1,
            'hotel_id' => $h->id,
            'room_id' => $room->id,
            'status_id' => 1,
            'reserved_at' => now(),
            'start_at' => now()->addDay(),
            'end_at' => now()->addDays(2),
            'guests' => 2,
            'total_price' => 5000
        ]);
    }
}
