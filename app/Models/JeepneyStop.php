<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JeepneyStop extends Model
{
    protected $table = 'jeepney_stops_table';

    protected $fillable = ['name', 'lat', 'lng'];

    public function routes()
    {
        return $this->belongsToMany(
            JeepneyRoute::class,
            'route_stop',
            'stop_id',
            'route_id'
        )->withPivot('stop_order')
         ->withTimestamps();
    }
}

