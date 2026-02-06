<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelReservation; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

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
        'updated_user',
        'email',
        'representative_name',
        'image_path',
    ];

    // ホテル画像との関係
    public function hotelImages()
    {
        return $this->hasMany(HotelImage::class);
    }

    // 部屋タイプとの関係
        

    // ホテルの予約情報
    // public function reservations()
    // {
    //     return $this->hasMany(HotelReservation::class);
    // }

    // ホテルの部屋タイプ
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
    // ホテルの部屋
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }
       public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

   
}
