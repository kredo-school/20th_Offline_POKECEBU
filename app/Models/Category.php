<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function hotelRooms()
    {
        return $this->belongsToMany(
            HotelRoom::class,
            'category_room',
            'category_id',
            'room_id'
        );
    }
}
