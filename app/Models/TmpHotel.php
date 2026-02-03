<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TmpHotel extends Model
{
<<<<<<< HEAD
    //
=======
    use HasFactory, SoftDeletes;

    // テーブル名は規約通りなら不要。明示する場合は以下を有効化
    // protected $table = 'tmp_hotels';

    protected $fillable = [
        'hotel_id',
        'updated_user',
        'name',
        'description',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'phone',
        'website',
        'status',
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
        return $this->hasMany(TmpHotelImage::class, 'tmp_hotel_id');
    }

    /**
     * 元の hotels テーブルの参照（ある場合）
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
    /**
     * 更新者（ユーザー）
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }



>>>>>>> main
}
