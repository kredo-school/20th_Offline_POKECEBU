<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableImage extends Model
{
    //
    protected $fillable = [
        'table_id',
        'image',
    ];

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }
}
