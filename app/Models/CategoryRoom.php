<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRoom extends Model
{
    protected $table = 'category_room';
    protected $fillable = ['category_id', 'room_id'];
    public $timestamps = false;
    protected $primaryKey = ['room_id', 'category_id'];
    public $incrementing = false;

    #To get the name of the category
    public function category() {
       return $this->belongsTo(Category::class);
    }
}
