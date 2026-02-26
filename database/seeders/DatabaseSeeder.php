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
            'types', 'statuses', 'categories', 'restaurants', 'hotels'
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
        $bookedStatusId = DB::table('statuses')->insertGetId(['name' => 'Booked', 'target_type' => 'all', 'created_at' => $now]);

        $categoryId = DB::table('categories')->insertGetId(['name' => 'Free Wi-Fi', 'target_type' => 'all', 'created_at' => $now]);

        /*
        |--------------------------------------------------------------------------
        | 3. Hotels, Hotel Images & Rooms (各ホテル5部屋 + 画像3枚)
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

            // hotel_images テーブルに画像を追加
            for ($img = 1; $img <= 3; $img++) {
                DB::table('hotel_images')->insert([
                    'hotel_id' => $hUserId,
                    'image' => "hotel_{$h}_img_{$img}.jpg",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

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
        | 4. Restaurants, Restaurant Images & Tables (各レストラン5テーブル + 画像3枚)
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

            // restaurant_images テーブルに画像を追加
            for ($img = 1; $img <= 3; $img++) {
                DB::table('restaurant_images')->insert([
                    'restaurant_id' => $rUserId,
                    'image' => "restaurant_{$r}_img_{$img}.jpg",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

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
        | 5. 大量の予約データ (過去14ヶ月分 / 合計800件)
        |--------------------------------------------------------------------------
        */
        for ($i = 0; $i < 800; $i++) {
            $reservedAt = Carbon::now()->subMonths(rand(0, 14))->subDays(rand(0, 28))->setTime(rand(8, 20), 0);

            // ホテル予約
            $roomInfo = $allRoomIds[array_rand($allRoomIds)];
            $startAt = $reservedAt->copy()->addDays(rand(1, 20));
            $endAt = $startAt->copy()->addDays(rand(1, 4));

            DB::table('hotel_reservations')->insert([
                'reservation_id' => 'HRES' . $faker->unique()->numberBetween(100000, 9999999),
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
                'reservation_id' => 'RRES' . $faker->unique()->numberBetween(100000, 9999999),
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
        // Restaurant用
        DB::table('restaurant_reservations')->insert([
            'reservation_id' => 20001,
            'user_id' => $userId,
            'restaurant_id' => 4,
            'table_id' => $tableId,
            'status_id' => 3,
            'guests' => 2,           // ★追加：こちらも人数を追加
            'total_price' => 1500,
            'reserved_at' => $now,
            'start_at' => $now->copy()->addDays(7)->setTime(18, 0),
            'end_at' => $now->copy()->addDays(7)->setTime(20, 0),
            'created_at' => $now,
            'updated_at' => $now,        // 念のため追加
            'other' => 'No request',
        ]);
      
        // FAQ
        DB::table('faq_categories')->updateOrInsert(['name' => 'Hotels'], ['soft_order' => 1, 'created_at' => $now, 'updated_at' => $now]);
        DB::table('faq_categories')->updateOrInsert(['name' => 'Restaurants'], ['soft_order' => 2, 'created_at' => $now, 'updated_at' => $now]);
        DB::table('faq_categories')->updateOrInsert(['name' => 'Plans/Reservations'], ['soft_order' => 3, 'created_at' => $now, 'updated_at' => $now]);

        DB::table('faqs')->updateOrInsert(['faq_category_id' => 1, 'title' => 'title1'], ['question' => 'question1', 'answer' => 'answer1', 'soft_order' => 1, 'created_at' => $now, 'updated_at' => $now]);
        DB::table('faqs')->updateOrInsert(['faq_category_id' => 1, 'title' => 'title2'], ['question' => 'question2', 'answer' => 'answer2', 'soft_order' => 2, 'created_at' => $now, 'updated_at' => $now]);
        DB::table('faqs')->updateOrInsert(['faq_category_id' => 1, 'title' => 'title3'], ['question' => 'question3', 'answer' => 'answer3', 'soft_order' => 3, 'created_at' => $now, 'updated_at' => $now]);
    }

    
}