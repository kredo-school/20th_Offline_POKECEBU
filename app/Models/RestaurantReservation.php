<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guest;
use App\Models\Restaurant;

class RestaurantReservation extends Model
{
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
