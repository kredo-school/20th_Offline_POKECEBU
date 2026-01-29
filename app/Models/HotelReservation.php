<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelReservation extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_id',
        'status_id',
        'reserved_at',
        'start_at',
        'end_at',
        'guests',
        'total_price',
        'updated_user'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // 部屋との関係
    public function room()
    {
        return $this->belongsTo(HotelRoom::class);
    }

    // ユーザーとの関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
