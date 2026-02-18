<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelReservation; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\HotelImage;
use App\Models\Review;

class Hotel extends Model
{
    // id を手動で設定する場合は incrementing を false にする
    public $incrementing = false;

    // keyType は int のまま
    protected $keyType = 'int';
    use HasFactory;

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
        'representative_email',
        'updated_user',
        'email',
        'image_path',
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

    public function hotelImages()
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
    // 部屋タイプとの関係
        

    // ホテルの予約情報
    // public function reservations()
    // {
    //     return $this->hasMany(HotelReservation::class);
    // }

    // ホテルの部屋タイプ
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
     * ホテルに対するレビュー（polymorphic）
     * reviews テーブルが target_type / target_id を使っている想定
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'target');
    }

        // （もしホテルとカテゴリが多対多で繋がっているなら）
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'hotel_category', 'hotel_id', 'category_id');
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
