<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelReservation; 


class Hotel extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'phone',
        'website',
        'updated_user'
    ];

    // ホテル画像との関係
    public function hotelImages()
    {
        return $this->hasMany(HotelImage::class);
    }

    // 部屋との関係
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    // 部屋タイプとの関係
    public function roomTypes()
    {
        return $this->hasMany(HotelRoomType::class);
    }

    // 予約との関係
    public function reservations()
    {
        return $this->hasMany(HotelReservation::class, 'hotel_id');
    }

    // 一時ホテル（申請中データ）との関係
    public function tmpHotels()
    {
        return $this->hasMany(TmpHotel::class, 'updated_user', 'updated_user');
    }
}
