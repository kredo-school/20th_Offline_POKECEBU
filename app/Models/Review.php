<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'target_type',
        'target_id',
        'rating',
        'comment'
    ];

    
    public function hotel() {
        return $this->belongsTo(Hotel::class);  
    }

    public function restaurant() {
       return $this->belongsTo(Restaurant::class);
    }

    public function user() {
       return $this->belongsTo(User::class);
    }

}
