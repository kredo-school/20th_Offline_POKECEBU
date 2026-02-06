<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // --- 1. 独立したマスターデータ ---
        $roleId = 1; // Admin
        $userId = DB::table('users')->insertGetId([
            'name' => 'CebuAdmin',
            'email' => 'admin@cebu.com',
            'password' => Hash::make('password123'),
            'role_id' => $roleId,
            'created_at' => $now,
        ]);

        DB::table('user_details')->insert([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '09123456789',
            'user_id' => $userId,
            'created_at' => $now,
        ]);

        $hotelTypeId = DB::table('types')->insertGetId(['name' => 'Deluxe Room', 'target_type' => 'hotel', 'created_at' => $now]);
        $restTypeId = DB::table('types')->insertGetId(['name' => 'Window Seat', 'target_type' => 'restaurant', 'created_at' => $now]);
        
        $statusId = DB::table('statuses')->insertGetId(['name' => 'Available', 'target_type' => 'all', 'created_at' => $now]);
        $catId = DB::table('categories')->insertGetId(['name' => 'Free Wi-Fi', 'target_type' => 'all', 'created_at' => $now]);

        // --- 2. ホテル関連 ---
        $hotelId = DB::table('hotels')->insertGetId([
            'name' => 'Ocean View Hotel', 'city' => 'Cebu City', 'star_rating' => 4.5, 'updated_user' => $userId, 'created_at' => $now
        ]);
        DB::table('tmp_hotels')->insert([
            'name' => 'Pending Luxury Resort', 'status' => '申請中', 'updated_user' => $userId, 'created_at' => $now
        ]);
        DB::table('hotel_images')->insert(['hotel_id' => $hotelId, 'image' => 'hotel1.jpg', 'created_at' => $now]);
        DB::table('hotel_room_types')->insert(['hotel_id' => $hotelId, 'type_id' => $hotelTypeId, 'total_rooms' => 10, 'created_at' => $now]);
        
        $roomId = DB::table('hotel_rooms')->insertGetId([
            'hotel_id' => $hotelId, 'type_id' => $hotelTypeId, 'max_guests' => 2, 'charges' => 3500, 'status_id' => $statusId, 'created_at' => $now
        ]);
        DB::table('room_images')->insert(['room_id' => $roomId, 'image' => 'room1.jpg', 'created_at' => $now]);
        DB::table('category_room')->insert(['room_id' => $roomId, 'category_id' => $catId]);

        // --- 3. レストラン関連 ---
        $restId = DB::table('restaurants')->insertGetId([
            'name' => 'Lechon King', 'city' => 'Mactan', 'star_rating' => 4.8, 'updated_user' => $userId, 'created_at' => $now
        ]);
        DB::table('tmp_restaurants')->insert([
            'name' => 'New Grill Bar', 'status' => '一時保存', 'updated_user' => $userId, 'created_at' => $now
        ]);
        DB::table('restaurant_images')->insert(['restaurant_id' => $restId, 'image' => 'rest1.jpg', 'created_at' => $now]);
        DB::table('restaurant_table_types')->insert(['restaurant_id' => $restId, 'type_id' => $restTypeId, 'total_tables' => 5, 'created_at' => $now]);
        
        // --- 4. Restaurants & Tables の部分 ---
$tableId = DB::table('restaurant_tables')->insertGetId([
    'restaurant_id' => $restId,
    'type_id'       => $restTypeId,
    'max_guests'    => 4,
    'status_id'     => $statusId,
    'charges'       => 0, // ★ここを追加！ (レストランの席料が無料なら 0)
    'created_at'    => $now,
]);

    // 5. Reservations
        // Hotel用
        DB::table('hotel_reservations')->insert([
            'reservation_id' => 10001,
            'user_id'     => $userId,
            'hotel_id'    => $hotelId,
            'room_id'     => $roomId,
            'status_id'   => $statusId,
            'guests'      => 2,           // ★追加：これが今回のエラー原因です！
            'total_price' => 7000,
            'reserved_at' => $now,
            'start_at'    => $now->copy()->addDays(7),
            'end_at'      => $now->copy()->addDays(8),
            'created_at'  => $now,
            'updated_at'  => $now,        // 念のため追加
        ]);

        // Restaurant用
        // ※マイグレーションで resrvation_id (e抜き) か reservation_id か確認してください
        // DBML通りなら resrvation_id ですが、もしエラーが出たら reservation_id に直してください
        DB::table('restaurant_reservations')->insert([
            'resrvation_id' => 20001, 
            'user_id'       => $userId,
            'restaurant_id' => $restId,
            'table_id'      => $tableId,
            'status_id'     => $statusId,
            'guests'        => 2,           // ★追加：こちらも人数を追加
            'total_price'   => 1500,
            'reserved_at'   => $now,
            'start_at'      => $now->copy()->addDays(7)->setTime(18, 0),
            'end_at'        => $now->copy()->addDays(7)->setTime(20, 0),
            'created_at'    => $now,
            'updated_at'    => $now,        // 念のため追加
        ]);
     }
}