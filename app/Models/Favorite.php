<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'target_type',
        'target_id'
    ];

    public function user() {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    
    public function target()
    {
        return $this->morphTo();
    }
}
