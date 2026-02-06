<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    // 複数代入可能なカラム
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
        'image_path',
        'owner_name',
        'email',
        'updated_user',
    ];
}
