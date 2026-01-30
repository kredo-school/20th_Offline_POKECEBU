<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
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
];
}
