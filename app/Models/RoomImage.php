<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    //
    public function room()
{
    return $this->belongsTo(HotelRoom::class, 'room_id');
}

    protected $fillable = [
        'room_id',
        'image'
    ];
}
