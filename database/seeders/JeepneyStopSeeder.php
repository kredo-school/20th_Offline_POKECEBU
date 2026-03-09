<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JeepneyStopSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jeepney_stops_table')->insert([
            ['name' => 'Ayala Center Cebu', 'lat' => 10.3187000, 'lng' => 123.9050000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IT Park (Cebu)', 'lat' => 10.3281000, 'lng' => 123.9063000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SM City Cebu', 'lat' => 10.3112000, 'lng' => 123.9180000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fuente Osmeña Circle', 'lat' => 10.3093000, 'lng' => 123.8923000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carbon Market', 'lat' => 10.2943000, 'lng' => 123.8976000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mactan Newtown', 'lat' => 10.3122000, 'lng' => 124.0046000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
