<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpRestaurant extends Model
{
    use HasFactory;

    // ここに編集可能なカラムを追加
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'phone',
        'website',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'representative_name',
        'representative_email',
        // 'email',
        'status',
        'image_path', // もし画像もある場合
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'star_rating' => 'float',
    ];

    /**
     * 申請に紐づく画像（複数）
     */
    public function images()
    {
        return $this->hasMany(TmpRestaurantImage::class, 'tmp_restaurant_id');
    }

     public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}