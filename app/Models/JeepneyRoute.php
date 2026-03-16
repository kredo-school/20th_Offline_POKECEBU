<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JeepneyRoute extends Model
{
    protected $table = 'jeepney_routes_table';

    protected $fillable = ['code', 'name', 'fare', 'notes'];

    public function routeStops()
{
    return $this->hasMany(RouteStop::class, 'route_id');
}

public function stops()
{
    return $this->belongsToMany(JeepneyStop::class, 'route_stop', 'route_id', 'stop_id')
                ->withPivot('stop_order')
                ->orderBy('pivot_stop_order');
}

}
