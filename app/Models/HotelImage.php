<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    //
    protected $fillable = [
        'hotel_id',
        'image'
    ];
    protected $table = 'hotel_images';

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
}
