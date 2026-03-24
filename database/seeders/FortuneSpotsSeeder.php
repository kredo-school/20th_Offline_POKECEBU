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
                'image' => "https://miro.medium.com/v2/resize:fit:965/1*_ODZre7ijbY3jk9adrs1jg.jpeg",
                'category' => "Historic",
                'is_active' => true,
            ],
            [
                'name' => "Temple of Leah",
                'description' => "A popular spot with magnificent architecture. Recommended for days when you want Instagram-worthy photos.",
                'location' => "Cebu City",
                'image' => "https://cebuinsider.com/wp-content/uploads/2023/08/Temple-of-Leah-Cebu-City.jpg",
                'category' => "Scenic",
                'is_active' => true,
            ],
            [
                'name' => "Sirao Garden",
                'description' => "A relaxing spot with colorful flowers and beautiful scenery. Perfect for spending a laid-back day.",
                'location' => "Cebu City",
                'image' => "https://tse1.mm.bing.net/th/id/OIP.MhThNU4C5DwJFCKqd9kMxAHaLk?rs=1&pid=ImgDetMain&o=7&rm=3",
                'category' => "Nature",
                'is_active' => true,
            ],
            [
                'name' => "TOPS Cebu",
                'description' => "A classic viewpoint overlooking Cebu City. Recommended for enjoying the night view.",
                'location' => "Busay",
                'image' => "https://www.topscebu.ph/_next/image?url=https:%2F%2Fcdn.sanity.io%2Fimages%2Foxei9udv%2Fproduction%2Fed70279bc18ddae5802d5554adb858f1ef87c89d-2048x1152.jpg%3Frect%3D0%2C0%2C1703%2C1152%26fm%3Dwebp&w=3840&q=75",
                'category' => "Viewpoint",
                'is_active' => true,
            ],
            [
                'name' => "Ayala Center Cebu",
                'description' => "A convenient spot where you can enjoy shopping and dining between sightseeing. Perfect for days when you want to move around casually.",
                'location' => "Cebu City",
                'image' => "https://cdn-ak.f.st-hatena.com/images/fotolife/n/newyorker24/20160720/20160720214257.png",
                'category' => "City",
                'is_active' => true,
            ],
        ];

        foreach ($spots as $spot) {
            FortuneSpot::create($spot);
        }
    }
}

