<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Guestの代わりにUserを使っている場合
use App\Models\Restaurant;

class RestaurantReservation extends Model
{
    // 1. 保存を許可するカラムを指定（これがないと保存できません！）
    protected $fillable = [
        'reservation_id',
        'user_id',
        'restaurant_id',
        'table_id',
        'status_id',
        'reserved_at',
        'start_at',
        'end_at',
        'guests',
        'total_price',
        'other'
    ];

    // 2. リレーション設定
    public function user()
    {
        // 外部キーが user_id なので、Userモデルと紐付けるのが一般的です
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}