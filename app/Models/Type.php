<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table = 'types'; // 明示的にテーブル名を指定（省略可）
     protected $fillable = [
        'name',
        'target_type',
    ];
    // ホテルルームタイプに紐付く
    public function hotelRoomTypes(): HasMany
    {

        return $this->hasMany(HotelRoomType::class, 'type_id');
    
    
    }
    public function restaurantTables()
    {
        return $this->hasMany(RestaurantTable::class);
    }
}
