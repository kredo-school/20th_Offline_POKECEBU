<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JeepneyStop extends Model
{
    protected $table = 'jeepney_stops_table';

    protected $fillable = ['name', 'lat', 'lng'];

    public function routeStops()
{
    return $this->hasMany(RouteStop::class, 'stop_id');
}

public function routes()
{
    return $this->belongsToMany(JeepneyRoute::class, 'route_stop', 'stop_id', 'route_id')
                ->withPivot('stop_order')
                ->orderBy('pivot_stop_order');
}

}

