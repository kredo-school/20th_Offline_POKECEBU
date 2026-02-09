<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $fillable = [
        'name',
        'target_type',
    ];

    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function restaurantTables()
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function hotelRoomStatuses() {
        return $this->hasMany(HotelRoom::class, 'status_id');
    }
}
