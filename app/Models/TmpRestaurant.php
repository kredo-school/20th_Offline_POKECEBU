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
}