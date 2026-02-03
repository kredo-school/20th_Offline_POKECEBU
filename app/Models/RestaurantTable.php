<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    //
    protected $fillable = [
        'name',
        // 他に必要なカラム
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
}
