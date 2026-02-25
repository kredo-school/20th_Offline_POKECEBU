<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpRestaurantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmp_restaurant_id',
        'image',
    ];

    public function tmpRestaurant()
    {
        return $this->belongsTo(TmpRestaurant::class, 'tmp_restaurant_id');
    }
}
