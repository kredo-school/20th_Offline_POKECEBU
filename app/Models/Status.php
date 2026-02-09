<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function hotelRoomStatuses() {
        return $this->hasMany(HotelRoom::class, 'status_id');
    }
}
