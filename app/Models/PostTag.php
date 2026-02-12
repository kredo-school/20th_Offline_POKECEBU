<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\PostTagPivot;

class PostTag extends Model
{
    protected $table = 'post_tags';
    protected $fillable = ['name'];
    public function posts() {
       return $this->belongsToMany(
        Post::class,
        'post_tag',
        'tag_id',
        'post_id'
        );
    }
}
