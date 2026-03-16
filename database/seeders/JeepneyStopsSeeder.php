<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JeepneyStop;

class JeepneyStopsSeeder extends Seeder
{
    public function run(): void
    {
        // 既存データを削除
        JeepneyStop::query()->delete();

        // AUTO_INCREMENT をリセット
        DB::statement('ALTER TABLE jeepney_stops_table AUTO_INCREMENT = 1');

        $stops = [
            ['name' => 'Ayala Center Cebu', 'lat' => 10.3187000, 'lng' => 123.9050000],
            ['name' => 'IT Park (Cebu)', 'lat' => 10.3281000, 'lng' => 123.9030000],
            ['name' => 'SM City Cebu', 'lat' => 10.3093000, 'lng' => 123.9060000],
            ['name' => 'Fuente Osmeña Circle', 'lat' => 10.3039000, 'lng' => 123.8940000],
            ['name' => 'Carbon Market', 'lat' => 10.2943000, 'lng' => 123.8970000],
            ['name' => 'Mactan Newtown', 'lat' => 10.3094000, 'lng' => 123.9630000],
            ['name' => 'Colon Street', 'lat' => 10.2960000, 'lng' => 123.8990000],
            ['name' => 'Lahug', 'lat' => 10.3200000, 'lng' => 123.9000000],
            ['name' => 'JY Square Mall', 'lat' => 10.3313000, 'lng' => 123.9000000],
            ['name' => 'Capitol Site', 'lat' => 10.3088000, 'lng' => 123.8890000],
            ['name' => 'Robinsons Galleria Cebu', 'lat' => 10.3090000, 'lng' => 123.9120000],
            ['name' => 'Pier 1', 'lat' => 10.2960000, 'lng' => 123.9050000],
            ['name' => 'South Bus Terminal', 'lat' => 10.2950000, 'lng' => 123.8810000],
            ['name' => 'University of San Carlos Main', 'lat' => 10.2940000, 'lng' => 123.8940000],
            ['name' => 'Talisay City', 'lat' => 10.2447000, 'lng' => 123.8490000],
        ];

        foreach ($stops as $stop) {
            JeepneyStop::create($stop);
        }
    }
}

