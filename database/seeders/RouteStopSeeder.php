<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RouteStopSeeder extends Seeder
{
    public function run(): void
    {
        // 既存データ削除 & IDリセット
        DB::table('route_stop')->truncate();

        $now = Carbon::now();

         DB::table('route_stop')->insert([
            // 17B
            ['route_id'=>1,'stop_id'=>2,'stop_order'=>1],
            ['route_id'=>1,'stop_id'=>1,'stop_order'=>2],
            ['route_id'=>1,'stop_id'=>4,'stop_order'=>3],
            ['route_id'=>1,'stop_id'=>7,'stop_order'=>4],
            ['route_id'=>1,'stop_id'=>5,'stop_order'=>5],

            // 17C
            ['route_id'=>2,'stop_id'=>8,'stop_order'=>1],
            ['route_id'=>2,'stop_id'=>4,'stop_order'=>2],
            ['route_id'=>2,'stop_id'=>7,'stop_order'=>3],
            ['route_id'=>2,'stop_id'=>5,'stop_order'=>4],

            // 13C
            ['route_id'=>3,'stop_id'=>3,'stop_order'=>1],
            ['route_id'=>3,'stop_id'=>11,'stop_order'=>2],
            ['route_id'=>3,'stop_id'=>1,'stop_order'=>3],
            ['route_id'=>3,'stop_id'=>4,'stop_order'=>4],

            // 12I
            ['route_id'=>4,'stop_id'=>6,'stop_order'=>1],
            ['route_id'=>4,'stop_id'=>3,'stop_order'=>2],

            // 13F
            ['route_id'=>5,'stop_id'=>10,'stop_order'=>1],
            ['route_id'=>5,'stop_id'=>4,'stop_order'=>2],
            ['route_id'=>5,'stop_id'=>7,'stop_order'=>3],
            ['route_id'=>5,'stop_id'=>14,'stop_order'=>4],
            ['route_id'=>5,'stop_id'=>5,'stop_order'=>5],

            // 04L
            ['route_id'=>6,'stop_id'=>9,'stop_order'=>1],
            ['route_id'=>6,'stop_id'=>8,'stop_order'=>2],
            ['route_id'=>6,'stop_id'=>2,'stop_order'=>3],
            ['route_id'=>6,'stop_id'=>1,'stop_order'=>4],

            // 10M
            ['route_id'=>7,'stop_id'=>12,'stop_order'=>1],
            ['route_id'=>7,'stop_id'=>7,'stop_order'=>2],
            ['route_id'=>7,'stop_id'=>14,'stop_order'=>3],
            ['route_id'=>7,'stop_id'=>5,'stop_order'=>4],

            // 10F
            ['route_id'=>8,'stop_id'=>13,'stop_order'=>1],
            ['route_id'=>8,'stop_id'=>10,'stop_order'=>2],
            ['route_id'=>8,'stop_id'=>4,'stop_order'=>3],
            ['route_id'=>8,'stop_id'=>1,'stop_order'=>4],

            // 10G
            ['route_id'=>9,'stop_id'=>15,'stop_order'=>1],
            ['route_id'=>9,'stop_id'=>13,'stop_order'=>2],
            ['route_id'=>9,'stop_id'=>7,'stop_order'=>3],

            // 09L
            ['route_id'=>10,'stop_id'=>11,'stop_order'=>1],
            ['route_id'=>10,'stop_id'=>3,'stop_order'=>2],
            ['route_id'=>10,'stop_id'=>12,'stop_order'=>3],
        ]);
    }
}

