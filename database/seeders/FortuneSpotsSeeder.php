<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FortuneSpot;

class FortuneSpotsSeeder extends Seeder
{
    public function run(): void
    {
        // Use delete instead of truncate
        FortuneSpot::query()->delete();

        DB::statement('ALTER TABLE fortune_spots AUTO_INCREMENT = 1');

        $spots = [
            [
                'name' => "Magellan's Cross",
                'description' => "A historic landmark representing Cebu. A classic sightseeing spot that is easy to visit even for a short time.",
                'location' => "Cebu City",
                'image' => "spots/magellans_cross.jpg",
                'category' => "Historic",
                'is_active' => true,
            ],
            [
                'name' => "Temple of Leah",
                'description' => "A popular spot with magnificent architecture. Recommended for days when you want Instagram-worthy photos.",
                'location' => "Cebu City",
                'image' => "spots/temple_of_leah.jpg",
                'category' => "Scenic",
                'is_active' => true,
            ],
            [
                'name' => "Sirao Garden",
                'description' => "A relaxing spot with colorful flowers and beautiful scenery. Perfect for spending a laid-back day.",
                'location' => "Cebu City",
                'image' => "spots/sirao_garden.jpg",
                'category' => "Nature",
                'is_active' => true,
            ],
            [
                'name' => "TOPS Cebu",
                'description' => "A classic viewpoint overlooking Cebu City. Recommended for enjoying the night view.",
                'location' => "Busay",
                'image' => "spots/tops_cebu.jpg",
                'category' => "Viewpoint",
                'is_active' => true,
            ],
            [
                'name' => "Ayala Center Cebu",
                'description' => "A convenient spot where you can enjoy shopping and dining between sightseeing. Perfect for days when you want to move around casually.",
                'location' => "Cebu City",
                'image' => "spots/ayala_center.jpg",
                'category' => "City",
                'is_active' => true,
            ],
        ];

        foreach ($spots as $spot) {
            FortuneSpot::create($spot);
        }
    }
}

