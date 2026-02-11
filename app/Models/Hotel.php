<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelReservation; 


class Hotel extends Model
{
    // id を手動で設定する場合は incrementing を false にする
    public $incrementing = false;

    // keyType は int のまま
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'phone',
        'website',
        'representative_name',
        'representative_email'
    ];

    /**
     * user リレーション（users.id と hotels.id を結ぶ）
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * ホテル画像との関係
     */
    public function images()
    {
        return $this->hasMany(HotelImage::class, 'hotel_id', 'id');
    }

    /**
     * 部屋との関係
     */
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class, 'hotel_id', 'id');
    }

    /**
     * 部屋タイプとの関係
     */
    public function roomTypes()
    {
        return $this->hasMany(HotelRoomType::class, 'hotel_id', 'id');
    }

    /**
     * 予約との関係
     */
    public function reservations()
    {
        return $this->hasMany(HotelReservation::class, 'hotel_id', 'id');
    }

    /**
     * 一時ホテル（申請中データ）との関係
     * tmp_hotels テーブルは申請時に hotel_id を保持する想定
     */
    public function tmpHotels()
    {
        return $this->hasMany(TmpHotel::class, 'hotel_id', 'id');
    }
}
