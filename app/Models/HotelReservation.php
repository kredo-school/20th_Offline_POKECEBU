<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_id',       // 必要に応じて
        'user_name',
        'user_email',
        'user_phone',
        'checkin_date',
        'checkout_date',
        'guests',
        'status',        // 未払い, 確定
        'price_total',
            'other', 
    ];

    // どのホテルの予約か
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }


    // ユーザーとの関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // どの部屋の予約か（必要に応じて）
    public function room()
    {
        return $this->belongsTo(HotelRoom::class, 'room_id');
    }
}
