<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guest;
use App\Models\Room;

class Reservation extends Model
{
    // 実テーブル名に合わせる
    protected $table = 'hotel_reservations';

    protected $fillable = [
        'room_id',
        'user_id',
        'start_at',
        'end_at',
    ];


    public function guest()
{
    return $this->belongsTo(Guest::class);
}

public function room()
{
    return $this->belongsTo(Room::class, 'room_id');
}

}
