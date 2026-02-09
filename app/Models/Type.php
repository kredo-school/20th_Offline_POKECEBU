<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function hotelRoomTypes() {
        return $this->hasMany(HotelRoomType::class, 'type_id');
    }
}
