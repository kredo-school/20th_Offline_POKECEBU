<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;


    // userからpostを取得する
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
       
    }

    
}
