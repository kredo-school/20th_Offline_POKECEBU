<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRoom extends Model
{
    //データベースの名前をcategory_roomsにあとで変更して、この下の1行を消す
    protected $table = 'category_room';

    protected $fillable = [
        'category_id',
        'room_id',
    ];

    public $timestamps = false;
    protected $primaryKey = ['room_id', 'category_id'];
    public $incrementing = false;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function room()
    {
        return $this->belongsTo(HotelRoom::class, 'room_id');
    }
}
