<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JeepneyRouteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jeepney_routes_table')->insert([
            ['code' => '17B', 'name' => 'Apas–Carbon via Jones', 'fare' => '₱13–₱18', 'notes' => 'Ayala周辺を通る想定。混雑: 朝夕', 'created_at' => now(), 'updated_at' => now()],
            ['code' => '04L', 'name' => 'Lahug–Carbon', 'fare' => '₱13–₱18', 'notes' => 'Lahug → Fuente → Carbon の想定', 'created_at' => now(), 'updated_at' => now()],
            ['code' => '13C', 'name' => 'SM City–Ayala–Fuente', 'fare' => '₱13–₱16', 'notes' => 'SM → Ayala → Fuente の想定', 'created_at' => now(), 'updated_at' => now()],
            ['code' => '23D', 'name' => 'Mactan–Cebu City', 'fare' => '₱15–₱35', 'notes' => 'マクタン側の仮ルート', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
