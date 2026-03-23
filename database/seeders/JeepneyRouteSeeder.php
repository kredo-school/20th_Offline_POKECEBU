<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JeepneyRoute;

class JeepneyRouteSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing data (recommended if foreign key constraints exist)
        JeepneyRoute::query()->delete();

        // Reset AUTO_INCREMENT
        DB::statement('ALTER TABLE jeepney_routes_table AUTO_INCREMENT = 1');

        $routes = [
            ['id' => 1, 'code' => '17B', 'name' => 'IT Park - Ayala - Fuente - Carbon', 'fare' => 'P13–P18', 'notes' => 'Route from IT Park through Ayala and Fuente heading to Carbon.'],
            ['id' => 2, 'code' => '17C', 'name' => 'Lahug - Fuente - Carbon', 'fare' => 'P13–P18', 'notes' => 'Route from Lahug passing through Fuente heading to Carbon.'],
            ['id' => 3, 'code' => '13C', 'name' => 'SM City - Ayala - Fuente', 'fare' => 'P13–P18', 'notes' => 'Route from SM City heading towards Ayala and Fuente.'],
            ['id' => 4, 'code' => '12I', 'name' => 'Mactan - SM City Cebu', 'fare' => 'P13–P18', 'notes' => 'Route from Mactan side heading to SM City Cebu.'],
            ['id' => 5, 'code' => '13F', 'name' => 'Capitol - Fuente - Colon - Carbon', 'fare' => 'P13–P18', 'notes' => 'Route from Capitol area passing through downtown.'],
            ['id' => 6, 'code' => '04L', 'name' => 'JY Square - Lahug - Ayala', 'fare' => 'P13–P18', 'notes' => 'Route from JY Square via Lahug heading to Ayala.'],
            ['id' => 7, 'code' => '10M', 'name' => 'Pier 1 - Colon', 'fare' => 'P13–P16', 'notes' => 'Route from the port area heading to Carbon.'],
            ['id' => 8, 'code' => '10F', 'name' => 'South Bus Terminal - Fuente - Ayala', 'fare' => 'P13–P16', 'notes' => 'Route from South Bus Terminal via Fuente heading to Ayala.'],
            ['id' => 9, 'code' => '10G', 'name' => 'Talisay City - South Bus Terminal - Colon', 'fare' => 'P15–P22', 'notes' => 'Route from Talisay side passing through South Bus Terminal.'],
            ['id' => 10, 'code' => '09L', 'name' => 'Robinsons Galleria - SM City - Pier 1', 'fare' => 'P13–P16', 'notes' => 'Route connecting areas near the port.'],
        ];

        foreach ($routes as $route) {
            JeepneyRoute::create($route);
        }
    }
}

