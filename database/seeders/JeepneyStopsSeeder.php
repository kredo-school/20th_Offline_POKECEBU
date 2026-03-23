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
            ['id'=>1, 'name'=>'Ayala Center Cebu', 'lat'=>10.317000, 'lng'=>123.905000],
            ['id'=>2, 'name'=>'IT Park (Cebu)', 'lat'=>10.324000, 'lng'=>123.912000],
            ['id'=>3, 'name'=>'SM City Cebu', 'lat'=>10.309000, 'lng'=>123.960000],
            ['id'=>4, 'name'=>'Fuente Osmeña Circle', 'lat'=>10.309000, 'lng'=>123.893000],
            ['id'=>5, 'name'=>'Carbon Market', 'lat'=>10.294000, 'lng'=>123.897000],
            ['id'=>6, 'name'=>'Mactan Newtown', 'lat'=>10.324000, 'lng'=>123.949000],
            ['id'=>7, 'name'=>'Colon Street', 'lat'=>10.300000, 'lng'=>123.900000],
            ['id'=>8, 'name'=>'Lahug', 'lat'=>10.320000, 'lng'=>123.900000],
            ['id'=>9, 'name'=>'JY Square Mall', 'lat'=>10.313000, 'lng'=>123.900000],
            ['id'=>10, 'name'=>'Capitol Site', 'lat'=>10.313000, 'lng'=>123.893000],
            ['id'=>11, 'name'=>'Robinsons Galleria Cebu', 'lat'=>10.309000, 'lng'=>123.960000],
            ['id'=>12, 'name'=>'Pier 1', 'lat'=>10.296000, 'lng'=>123.960000],
            ['id'=>13, 'name'=>'South Bus Terminal', 'lat'=>10.300000, 'lng'=>123.891000],
            ['id'=>14, 'name'=>'University of San Carlos Main', 'lat'=>10.294000, 'lng'=>123.900000],
            ['id'=>15, 'name'=>'Talisay City', 'lat'=>10.244700, 'lng'=>123.849000],
        ];

        foreach ($stops as $stop) {
            JeepneyStop::create($stop);
        }
    }
}

