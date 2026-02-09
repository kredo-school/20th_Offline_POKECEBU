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

    $roles = [
        2 => 'admin',
        3 => 'hotel',
        4 => 'restaurant',
    ];

    foreach ($roles as $roleId => $roleName) {

        $userId = DB::table('users')->insertGetId([
            'name' => $roleName,
            'email' => $roleName . '@gmail.com',
            'email_verified_at' => $now,
            'password' => Hash::make('12345678'),
            'role_id' => $roleId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('user_details')->insert([
            'first_name' => ucfirst($roleName),
            'last_name' => 'User',
            'birthday' => '1990-01-01', // サンプル誕生日
            'phone' => '09123456789',
            'street_address' => '123 Sample Street',
            'city' => 'Cebu City',
            'state' => 'Cebu',
            'postal_code' => '6000',
            'avatar' => 'default-avatar.png', // デフォルト画像
            'user_id' => $userId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }


        $hotelTypeId = DB::table('types')->insertGetId(['name' => 'Deluxe Room', 'target_type' => 'hotel', 'created_at' => $now]);
        $hotelTypeId = DB::table('types')->insertGetId(['name' => 'Suite Room', 'target_type' => 'hotel', 'created_at' => $now]);
        $restTypeId = DB::table('types')->insertGetId(['name' => 'Window Seat', 'target_type' => 'restaurant', 'created_at' => $now]);
        
        $statusId = DB::table('statuses')->insertGetId(['name' => 'Available', 'target_type' => 'all', 'created_at' => $now]);
        $statusId = DB::table('statuses')->insertGetId(['name' => 'Unavailable', 'target_type' => 'all', 'created_at' => $now]);
        $catId = DB::table('categories')->insertGetId(['name' => 'Free Wi-Fi', 'target_type' => 'all', 'created_at' => $now]);

        // --- 2. ホテル関連 ---
$hotelId = DB::table('hotels')->insertGetId([
    'name' => 'Ocean View Hotel',
    'description' => 'A beautiful hotel overlooking the ocean, perfect for relaxing vacations.',
    'address' => '123 Seaside Avenue',
    'city' => 'Cebu City',
    'latitude' => 10.3157,
    'longitude' => 123.8854,
    'star_rating' => 4.5,
    'phone' => '09123456789',
    'website' => 'https://oceanviewhotel.example.com',
    'updated_user' => $userId,
    'created_at' => $now,
    'updated_at' => $now,
]);

        $now = now();

DB::table('tmp_hotels')->insert([
    [
        'name' => 'Pending Luxury Resort',
        'description' => 'A luxurious resort pending approval. Enjoy stunning ocean views and top-notch amenities.',
        'address' => '123 Beachfront Avenue',
        'city' => 'Cebu City',
        'latitude' => 10.3157,
        'longitude' => 123.8854,
        'star_rating' => 5,
        'phone' => '09123456789',
        'website' => 'https://pendingluxuryresort.example.com',
        'status' => '申請中',
        'updated_user' => 1, // ★ここは適切なユーザーIDに置き換えてください
        'created_at' => $now,
        'updated_at' => $now,
        'deleted_at' => null,
    ],
    [
        'name' => 'Pending Cozy Inn',
        'description' => 'A small cozy inn awaiting approval. Perfect for budget travelers.',
        'address' => '45 Mango Street',
        'city' => 'Mandaue',
        'latitude' => 10.3200,
        'longitude' => 123.9167,
        'star_rating' => 3,
        'phone' => '09987654321',
        'website' => 'https://pendingcozyinn.example.com',
        'status' => '申請中',
        'updated_user' => 1, // ★ここは適切なユーザーIDに置き換えてください
        'created_at' => $now,
        'updated_at' => $now,
        'deleted_at' => null,
    ]
]);

        DB::table('hotel_images')->insert(['hotel_id' => $hotelId, 'image' => 'sample_hotel_1.jpg', 'created_at' => $now]);
        DB::table('hotel_images')->insert(['hotel_id' => $hotelId, 'image' => 'sample_hotel_2.jpg', 'created_at' => $now]);
        DB::table('hotel_images')->insert(['hotel_id' => $hotelId, 'image' => 'sample_hotel_3.jpg', 'created_at' => $now]);
        DB::table('hotel_room_types')->insert(['hotel_id' => $hotelId, 'type_id' => $hotelTypeId, 'total_rooms' => 10, 'created_at' => $now]);
        
        $roomId = DB::table('hotel_rooms')->insertGetId([
            'hotel_id' => $hotelId, 'type_id' => $hotelTypeId, 'max_guests' => 2, 'charges' => 3500, 'status_id' => $statusId, 'created_at' => $now
        ]);
        DB::table('room_images')->insert(['room_id' => $roomId, 'image' => 'sample_room_1.jpg', 'created_at' => $now]);
        DB::table('room_images')->insert(['room_id' => $roomId, 'image' => 'sample_room_2.jpg', 'created_at' => $now]);
        DB::table('category_room')->insert(['room_id' => $roomId, 'category_id' => $catId]);

        // --- 3. レストラン関連 ---

$restId = DB::table('restaurants')->insertGetId([
    'name' => 'Lechon King',
    'description' => 'Famous for its delicious Cebu-style lechon, perfect for family meals and celebrations.',
    'address' => '456 Mactan Road',
    'city' => 'Mactan',
    'latitude' => 10.3070,
    'longitude' => 123.9840,
    'star_rating' => 4.8,
    'phone' => '09129876543',
    'website' => 'https://lechonking.example.com',
    'updated_user' => $userId,
    'created_at' => $now,
    'updated_at' => $now,
]);

DB::table('tmp_restaurants')->insert([
    'name' => 'New Grill Bar',
    'description' => 'A cozy place for grilled specialties and drinks.',
    'address' => '456 Sample Avenue',
    'city' => 'Mactan',
    'latitude' => 10.3157,
    'longitude' => 123.8854,
    'star_rating' => 4.2,
    'phone' => '09123456790',
    'website' => 'https://newgrillbar.example.com',
    'status' => '一時保存', // Pending / Temporary / Draft status
    'updated_user' => $userId, // シードしたユーザーID
    'created_at' => $now,
    'updated_at' => $now,
    'deleted_at' => null, // ソフトデリート用
]);

        DB::table('restaurant_images')->insert(['restaurant_id' => $restId, 'image' => 'rest1.jpg', 'created_at' => $now]);
        DB::table('restaurant_images')->insert(['restaurant_id' => $restId, 'image' => 'rest2.jpg', 'created_at' => $now]);
        DB::table('restaurant_images')->insert(['restaurant_id' => $restId, 'image' => 'rest3.jpg', 'created_at' => $now]);
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
        DB::table('category_table')->insert(['table_id' => $tableId, 'category_id' => $catId]);
        DB::table('table_images')->insert(['table_id' => $tableId, 'image' => 'sample_table_1.jpg', 'created_at' => $now]);
        DB::table('table_images')->insert(['table_id' => $tableId, 'image' => 'sample_table_2.jpg', 'created_at' => $now]);


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
        DB::table('restaurant_reservations')->insert([
            'reservation_id' => 20001, 
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