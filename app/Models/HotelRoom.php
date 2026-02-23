<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelRoom extends Model
{
    protected $fillable = [
        'hotel_id',
        'type_id',
        'floor_number',
        'max_guests',
        'charges',
        'status_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // 部屋タイプとの関係（必要なら）
    public function roomType()
    {
        return $this->belongsTo(HotelRoomType::class, 'type_id');
    }

    public function categoryRooms()
    {
        return $this->hasMany(CategoryRoom::class, 'room_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_room',
            'room_id',
            'category_id'
        );
    }

    // テーブル名が自動判定（hotel_rooms）と違う場合は以下を追記
    // protected $table = 'hotel_rooms';

    /**
     * この部屋が属する「部屋タイプ」を取得
     */
    public function hotelRoomType(): BelongsTo
    {
        // hotel_room_typesテーブルのtype_idと紐付け
        return $this->belongsTo(HotelRoomType::class, 'type_id', 'type_id');
    }



    /**
     * 「シングル」「ダブル」などのマスター名を取得したい場合
     */
    public function typeMaster(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
    
    public function reservations()
    {
        return $this->hasMany(HotelReservation::class, 'room_id', 'id');
    }
}
