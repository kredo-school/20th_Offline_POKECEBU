<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FortuneSpot extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'image',
        'category',
        'is_active',
    ];

    public function logs()
    {
        return $this->hasMany(DailyFortuneLog::class);
    }
}
