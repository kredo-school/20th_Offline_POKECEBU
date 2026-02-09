<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpHotelImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmp_hotel_id',
        'image',
    ];

    public function tmpHotel()
    {
        return $this->belongsTo(TmpHotel::class, 'tmp_hotel_id');
    }
}
