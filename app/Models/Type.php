<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
     protected $fillable = [
        'name',
        'target_type',
    ];

    public function restaurantTables()
    {
        return $this->hasMany(RestaurantTable::class);
    }
}
