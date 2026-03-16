<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JeepneyRoute;

class JeepneyRoutesSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing data (recommended if foreign key constraints exist)
        JeepneyRoute::query()->delete();

        // Reset AUTO_INCREMENT
        DB::statement('ALTER TABLE jeepney_routes_table AUTO_INCREMENT = 1');

        $routes = [
            [
                'code' => '17B',
                'name' => 'IT Park - Ayala - Fuente - Carbon',
                'fare' => '₱13–₱18',
                'notes' => 'Route from IT Park through Ayala and Fuente heading to Carbon.',
            ],
            [
                'code' => '04L',
                'name' => 'Lahug - Fuente - Carbon',
                'fare' => '₱13–₱18',
                'notes' => 'Route from Lahug passing through Fuente heading to Carbon.',
            ],
            [
                'code' => '13C',
                'name' => 'SM City - Ayala - Fuente',
                'fare' => '₱13–₱18',
                'notes' => 'Route from SM City heading towards Ayala and Fuente.',
            ],
            [
                'code' => '23D',
                'name' => 'Mactan Newtown - SM City Cebu',
                'fare' => '₱15–₱35',
                'notes' => 'Route from Mactan side heading to SM City Cebu.',
            ],
            [
                'code' => '12I',
                'name' => 'Capitol - Fuente - Colon - Carbon',
                'fare' => '₱13–₱18',
                'notes' => 'Route from Capitol area passing through downtown.',
            ],
            [
                'code' => '06H',
                'name' => 'JY Square - Lahug - Ayala',
                'fare' => '₱13–₱18',
                'notes' => 'Route from JY Square via Lahug heading to Ayala.',
            ],
            [
                'code' => '08G',
                'name' => 'Pier 1 - Colon - Carbon',
                'fare' => '₱13–₱16',
                'notes' => 'Route from the port area heading to Carbon.',
            ],
            [
                'code' => '10M',
                'name' => 'South Bus Terminal - Fuente - Ayala',
                'fare' => '₱13–₱18',
                'notes' => 'Route from South Bus Terminal via Fuente heading to Ayala.',
            ],
            [
                'code' => '14Q',
                'name' => 'Talisay City - South Bus Terminal - Colon',
                'fare' => '₱15–₱22',
                'notes' => 'Route from Talisay side passing through South Bus Terminal and Colon.',
            ],
            [
                'code' => '21R',
                'name' => 'Robinsons Galleria - SM City - Pier 1',
                'fare' => '₱13–₱16',
                'notes' => 'Route connecting areas near the port.',
            ],
        ];

        foreach ($routes as $route) {
            JeepneyRoute::create($route);
        }
    }
}

