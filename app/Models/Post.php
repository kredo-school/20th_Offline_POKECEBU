<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use SoftDeletes;

protected $fillable = [ 
    'user_id',
    'title',
    'body'
];
    
    
    // userからpostを取得する
    public function user() {
        return $this->belongsTo(User::class);
       
    }

    // postImageから画像取得
    public function images() {
        return $this->hasMany(PostImage::class);
       
    }

    public function tags() {
       return $this->belongsToMany(
        PostTag::class,
        'post_tag',
        'post_id',
        'tag_id'
        );
    }    

    public function likes() {
       return $this->hasMany(Like::class);
    }

    public function isLiked() {
       return $this->likes()->where('user_id',Auth::user()->id)->exists();
    }
}
