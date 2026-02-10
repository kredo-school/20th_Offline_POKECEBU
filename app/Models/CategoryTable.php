<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTable extends Model
{
    //データベースの名前をcategory_tablesにあとで変更して、この下の1行を消す
    protected $table = 'category_table';
    protected $fillable = [
        'category_id',
        'table_id',
    ];

    public $timestamps = false;
    protected $primaryKey = ['table_id', 'category_id'];
    public $incrementing = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }
}
