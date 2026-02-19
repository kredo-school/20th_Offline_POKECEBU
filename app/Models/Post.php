<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PostImage;
use App\Models\Comment;


class Post extends Model{
    use SoftDeletes;

    protected $fillable = [ 
    'user_id',
    'title',
    'body'
    ];
    
    
    // ポスト取得する
    public function user() {
        return $this->belongsTo(User::class);
    }

    // 画像取得
    public function images() {
        return $this->hasMany(PostImage::class);
    }

    // タグ
    public function tags() {
       return $this->belongsToMany(
        PostTag::class,
        'post_tag',
        'post_id',
        'tag_id'
        );
    }    

    // いいね！
    public function likes() {
       return $this->hasMany(Like::class);
    }

    public function isLiked() {
       return $this->likes()->where('user_id',Auth::user()->id)->exists();
    }

    // コメント
    public function comments() {
       return $this->hasMany(Comment::class);
    }
}
