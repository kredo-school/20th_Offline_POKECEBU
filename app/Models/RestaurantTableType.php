<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RestaurantTableType extends Model
{
    protected $fillable = [
        'restaurant_id',
        'type_id',
        'total_tables',
        'soft_delete'
    ];

    public function tables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class, 'type_id', 'type_id')
                    ->whereColumn('restaurant_tables.restaurant_id','restaurant_table_types.restaurant_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
