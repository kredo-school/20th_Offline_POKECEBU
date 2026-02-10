<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    //
    
        protected $fillable = [
            'restaurant_id',
            'type_id',
            'max_guests',
            'status_id',
        ];

    public function categoryTables()
    {
        return $this->hasMany(CategoryTable::class, 'table_id');
    }

    // カテゴリーを直接取りたい場合
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_table',
            'table_id',
            'category_id'
        );
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function images()
    {
    return $this->hasMany(TableImage::class, 'table_id');
    }


    // types table
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    // statuses table
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
