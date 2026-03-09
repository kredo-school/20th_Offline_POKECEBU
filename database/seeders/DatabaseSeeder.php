<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now();
        $this->call([
        JeepneyStopSeeder::class,
        JeepneyRouteSeeder::class,
    ]);

        /*
        |--------------------------------------------------------------------------
        | 外部キー制約 一時無効化 & truncate
        |--------------------------------------------------------------------------
        */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'tmp_hotel_images', 'tmp_hotels', 'hotel_images', 'restaurant_images', 
            'tmp_restaurants', 'room_images', 'hotel_rooms', 'hotel_room_types', 
            'hotel_reservations', 'restaurant_tables', 'table_images', 
            'restaurant_reservations', 'category_table', 'users', 'user_details', 
            'types', 'statuses', 'categories', 'restaurants', 'hotels',
            'faq_categories', 'faqs'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*
        |--------------------------------------------------------------------------
        | 1. Roles & Users (基本ユーザー)
        |--------------------------------------------------------------------------
        */
        $roles = [1 => 'customer', 2 => 'admin', 3 => 'hotel', 4 => 'restaurant'];
        $userIds = [];

        foreach ($roles as $roleId => $roleName) {
            $userId = DB::table('users')->insertGetId([
                'name' => ucfirst($roleName),
                'email' => $roleName . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => $roleId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $userIds[$roleName] = $userId;

            DB::table('user_details')->insert([
                'first_name' => ucfirst($roleName),
                'last_name' => 'User',
                'birthday' => '1990-01-01',
                'phone' => '09123456789',
                'street_address' => $faker->streetAddress,
                'city' => 'Cebu City',
                'state' => 'Cebu',
                'postal_code' => '6000',
                'avatar' => 'default-avatar.png',
                'user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Types, Statuses, Categories
        |--------------------------------------------------------------------------
        */
        $deluxeTypeId = DB::table('types')->insertGetId(['name' => 'Deluxe Room', 'target_type' => 'hotel', 'created_at' => $now]);
        $suiteTypeId = DB::table('types')->insertGetId(['name' => 'Suite Room', 'target_type' => 'hotel', 'created_at' => $now]);
        $windowTypeId = DB::table('types')->insertGetId(['name' => 'Window Seat', 'target_type' => 'restaurant', 'created_at' => $now]);
        $familyTypeId = DB::table('types')->insertGetId(['name' => 'Family Table', 'target_type' => 'restaurant', 'created_at' => $now]);

        $availableStatusId = DB::table('statuses')->insertGetId(['name' => 'Available', 'target_type' => 'all', 'created_at' => $now]);
        $unavailableStatusId = DB::table('statuses')->insertGetId(['name' => 'Unavailable', 'target_type' => 'all', 'created_at' => $now]);
        $bookedStatusId = DB::table('statuses')->insertGetId(['name' => 'Booked', 'target_type' => 'all', 'created_at' => $now]);
        $preparingStatusId = DB::table('statuses')->insertGetId(['name' => 'Preparing', 'target_type' => 'all', 'created_at' => $now]);
        $cancelledStatusId = DB::table('statuses')->insertGetId(['name' => 'Cancelled', 'target_type' => 'all', 'created_at' => $now]);

        $categoryId = DB::table('categories')->insertGetId(['name' => 'Free Wi-Fi', 'target_type' => 'all', 'created_at' => $now]);

        /*
        |--------------------------------------------------------------------------
        | 3. Hotels, Hotel Images & Rooms (ホテルごとに5部屋 + 画像3枚)
        |--------------------------------------------------------------------------
        */
        $numHotels = 5;
        $allRoomIds = [];

        for ($h = 1; $h <= $numHotels; $h++) {
            $hUserId = DB::table('users')->insertGetId([
                'name' => "Hotel Owner {$h}",
                'email' => "hotel_owner{$h}@gmail.com",
                'password' => Hash::make('12345678'),
                'role_id' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('hotels')->insert([
                'id' => $hUserId,
                'name' => $faker->company . " Luxury Resort",
                'description' => $faker->paragraph,
                'address' => $faker->address,
                'city' => 'Cebu City',
                'latitude' => $faker->latitude(10.2, 10.4),
                'longitude' => $faker->longitude(123.8, 124.0),
                'star_rating' => $faker->randomFloat(1, 3, 5),
                'phone' => $faker->phoneNumber,
                'website' => $faker->url,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('hotel_room_types')->insert([
                ['hotel_id' => $hUserId, 'type_id' => $deluxeTypeId, 'total_rooms' => 3, 'created_at' => $now],
                ['hotel_id' => $hUserId, 'type_id' => $suiteTypeId, 'total_rooms' => 2, 'created_at' => $now],
            ]);

            for ($r = 1; $r <= 5; $r++) {
                $typeId = ($r <= 3) ? $deluxeTypeId : $suiteTypeId;
                $roomId = DB::table('hotel_rooms')->insertGetId([
                    'hotel_id' => $hUserId,
                    'type_id' => $typeId,
                    'room_number' => ($h * 100) + $r,
                    'max_guests' => ($typeId == $suiteTypeId) ? 4 : 2,
                    'charges' => ($typeId == $suiteTypeId) ? 8000 : 4000,
                    'status_id' => $availableStatusId,
                    'detail' => $faker->text(150),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $allRoomIds[] = ['id' => $roomId, 'hotel_id' => $hUserId];

                DB::table('room_images')->insert([
                    'room_id' => $roomId, 'image' => 'sample_room.jpg', 'created_at' => $now, 'updated_at' => $now
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Restaurants, Restaurant Images & Tables (レストランごとに5テーブル + 画像3枚)
        |--------------------------------------------------------------------------
        */
        $numRestaurants = 5;
        $allTableIds = [];

        for ($r = 1; $r <= $numRestaurants; $r++) {
            $rUserId = DB::table('users')->insertGetId([
                'name' => "Resto Owner {$r}",
                'email' => "restaurant_owner{$r}@gmail.com",
                'password' => Hash::make('12345678'),
                'role_id' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('restaurants')->insert([
                'id' => $rUserId,
                'name' => $faker->company . " Kitchen",
                'description' => $faker->paragraph,
                'address' => $faker->address,
                'city' => 'Mactan',
                'latitude' => $faker->latitude(10.2, 10.4),
                'longitude' => $faker->longitude(123.8, 124.0),
                'star_rating' => $faker->randomFloat(1, 3, 5),
                'phone' => $faker->phoneNumber,
                'website' => $faker->url,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            for ($t = 1; $t <= 5; $t++) {
                $typeId = ($t <= 3) ? $windowTypeId : $familyTypeId;
                $tableId = DB::table('restaurant_tables')->insertGetId([
                    'restaurant_id' => $rUserId,
                    'type_id' => $typeId,
                    'max_guests' => ($typeId == $windowTypeId) ? 2 : 6,
                    'status_id' => $availableStatusId,
                    'charges' => 0,
                    'table_number' => "T-{$t}",
                    'detail' => $faker->text(100),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $allTableIds[] = ['id' => $tableId, 'restaurant_id' => $rUserId];

                DB::table('table_images')->insert(['table_id' => $tableId, 'image' => 'sample_table.jpg', 'created_at' => $now]);
                DB::table('category_table')->insert(['table_id' => $tableId, 'category_id' => $categoryId]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. 予約データの生成 (計800件)
        |--------------------------------------------------------------------------
        */
        for ($i = 0; $i < 800; $i++) {
            $reservedAt = Carbon::now()->subMonths(rand(0, 14))->subDays(rand(0, 28))->setTime(rand(8, 20), 0);

            // ホテル予約
            $roomInfo = $allRoomIds[array_rand($allRoomIds)];
            $startAt = $reservedAt->copy()->addDays(rand(1, 20));
            $endAt = $startAt->copy()->addDays(rand(1, 4));

            DB::table('hotel_reservations')->insert([
                'reservation_id' => 'HRES' . $faker->unique(true)->numberBetween(100000, 9999999),
                'user_id' => $userIds['customer'],
                'hotel_id' => $roomInfo['hotel_id'],
                'room_id' => $roomInfo['id'],
                'status_id' => $bookedStatusId,
                'guests' => rand(1, 4),
                'total_price' => rand(5000, 30000),
                'reserved_at' => $reservedAt,
                'start_at' => $startAt,
                'end_at' => $endAt,
                'other' => $faker->sentence,
                'created_at' => $reservedAt,
                'updated_at' => $reservedAt,
            ]);

            // レストラン予約
            $tableInfo = $allTableIds[array_rand($allTableIds)];
            $resStart = $reservedAt->copy()->addDays(rand(1, 20))->setTime(rand(11, 20), 0);

            DB::table('restaurant_reservations')->insert([
                'reservation_id' => 'RRES' . $faker->unique(true)->numberBetween(100000, 9999999),
                'user_id' => $userIds['customer'],
                'restaurant_id' => $tableInfo['restaurant_id'],
                'table_id' => $tableInfo['id'],
                'status_id' => $bookedStatusId,
                'guests' => rand(1, 6),
                'total_price' => rand(1000, 8000),
                'reserved_at' => $reservedAt,
                'start_at' => $resStart,
                'end_at' => $resStart->copy()->addHours(2),
                'other' => $faker->sentence,
                'created_at' => $reservedAt,
                'updated_at' => $reservedAt,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. FAQ データの生成
        |--------------------------------------------------------------------------
        */
        DB::table('faq_categories')->insert([
            ['name' => 'Hotels', 'soft_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Restaurants', 'soft_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Reservations', 'soft_order' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);

        for ($f = 1; $f <= 6; $f++) {
            DB::table('faqs')->insert([
                'faq_category_id' => rand(1, 3),
                'title' => "Question Topic $f",
                'question' => "This is the sample question $f?",
                'answer' => "This is the sample answer $f from the admin.",
                'soft_order' => $f,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

                /*
        |--------------------------------------------------------------------------
        | 7. 一般ユーザー (role_id: 1) を30名追加生成
        |--------------------------------------------------------------------------
        | 分析画面でグラフが表示されるよう、作成日を過去12ヶ月間でバラけさせる
        */
        for ($u = 1; $u <= 30; $u++) {
            // 過去0ヶ月〜11ヶ月前までのランダムな日時を生成
            $randomDate = Carbon::now()
                ->subMonths(rand(0, 11))
                ->subDays(rand(0, 28))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59));
        
            $uId = DB::table('users')->insertGetId([
                'name' => $faker->userName,
                'email' => "user_{$u}_{$faker->unique()->safeEmail}",
                'password' => Hash::make('12345678'),
                'role_id' => 1, // 一般ユーザー
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        
            DB::table('user_details')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birthday' => $faker->date('Y-m-d', '2005-01-01'),
                'phone' => $faker->phoneNumber,
                'street_address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'postal_code' => $faker->postcode,
                'avatar' => 'default-avatar.png',
                'user_id' => $uId,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}