<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoomType extends Model
{
    protected $fillable = [
        'hotel_id',
        'type_id',
        'total_rooms',
        'soft_delete'
    ];

    // この部屋タイプが属するホテル
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // この部屋タイプが参照するタイプ（types テーブル）
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function rooms()
    {
        return $this->hasMany(
            HotelRoom::class,
            'type_id',        // hotel_rooms 側のカラム
            'type_id'         // hotel_room_types 側のカラム
        );
    }
}
