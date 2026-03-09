<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JeepneyRoute extends Model
{
    protected $table = 'jeepney_routes_table';

    protected $fillable = ['code', 'name', 'fare', 'notes'];

    public function stops()
    {
        return $this->belongsToMany(
            JeepneyStop::class,
            'route_stop',
            'route_id',
            'stop_id'
        )->withPivot('stop_order')
         ->orderBy('route_stop.stop_order')
         ->withTimestamps();
    }
}
