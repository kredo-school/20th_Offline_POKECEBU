<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteStop extends Model
{
    use HasFactory;

    // テーブル名を明示
    protected $table = 'route_stop';

    // create() で使うカラムを指定
    protected $fillable = [
        'route_id',
        'stop_id',
        'stop_order',
    ];

    // リレーション定義
    public function route()
    {
        return $this->belongsTo(JeepneyRoute::class, 'route_id');
    }

    public function stop()
    {
        return $this->belongsTo(JeepneyStop::class, 'stop_id');
    }
}


