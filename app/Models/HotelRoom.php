<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    //
    protected $fillable = [
        'name',
        // 他に必要なカラム
    ];

    public function categoryRooms()
    {
        return $this->hasMany(CategoryRoom::class, 'room_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_room',
            'room_id',
            'category_id'
        );
    }
}
