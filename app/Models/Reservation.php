<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guest;
use App\Models\Room;

class Reservation extends Model
{
    public function guest()
{
    return $this->belongsTo(Guest::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}

}
