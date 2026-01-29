<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    //
    protected $fillable = [
        'hotel_id',
        'type_id',
        'floor_number',
        'max_guests',
        'charges',
        'status_id'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // 部屋タイプとの関係（必要なら）
    public function roomType()
    {
        return $this->belongsTo(HotelRoomType::class, 'type_id');
    }
}
