<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'target_type', // hotel | restaurant
    ];

    public function categoryRooms()
    {
        return $this->hasMany(CategoryRoom::class);
    }

    public function categoryTables()
    {
        return $this->hasMany(CategoryTable::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(
            HotelRoom::class,
            'category_rooms', // pivotテーブル名
            'category_id',
            'room_id'
        );
    }

    // レストラン用 pivot
    public function tables()
    {
        return $this->belongsToMany(
            RestaurantTable::class,
            'category_tables', // pivotテーブル名
            'category_id',
            'table_id'
        );
    }
    
}