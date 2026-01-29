<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpHotel extends Model
{
    protected $fillable = [
        'hotel_id',
        'updated_user',
        'name',
        'description',
        'address',
        'city',
        // 必要なカラムを追加
    ];

    // 元のホテル（ある場合）
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    // 更新者（ユーザー）
    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_user');
    }
}
