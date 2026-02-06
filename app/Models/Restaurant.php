<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'phone',
        'website',
        'updated_user',
    ];

    // restaurant_images
    public function restaurantImages()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    // restaurant_tables
    public function tables()
    {
        return $this->hasMany(RestaurantTable::class);
    }
}
