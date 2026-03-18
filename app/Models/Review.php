<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_reservation_id',
        'restaurant_reservation_id',
        'rating',
        'comment'
    ];

    public function user() {
       return $this->belongsTo(User::class);
    }

    public function hotelReservation() {
       return $this->belongsTo(HotelReservation::class);
    }

    public function restaurantReservation() {
       return $this->belongsTo(RestaurantReservation::class);
    }

     public function getHotelAttribute() {
        return $this->hotelReservation?->hotel;
    }

    public function getRestaurantAttribute() {
        return $this->restaurantReservation?->restaurant;
    }

}
