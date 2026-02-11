<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
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
     * user リレーション（users.id と restaurants.id を結ぶ）
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * 画像との関係
     */
    public function images()
    {
        return $this->hasMany(RestaurantImage::class, 'restaurant_id', 'id');
    }

    /**
     * テーブル（席）との関係
     */
    public function tables()
    {
        return $this->hasMany(RestaurantTable::class, 'restaurant_id', 'id');
    }
}
