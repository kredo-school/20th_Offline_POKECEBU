<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyFortuneLog extends Model
{
    protected $fillable = [
        'user_id',
        'fortune_spot_id',
        'fortune_date',
    ];

    protected $casts = [
        'fortune_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fortuneSpot()
    {
        return $this->belongsTo(FortuneSpot::class);
    }
}
