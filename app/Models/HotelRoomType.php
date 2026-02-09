<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelRoomType extends Model
{
    protected $fillable = [
        'hotel_id',
        'type_id',
        'total_rooms',
        'soft_delete'
    ];

    // この部屋タイプが属するホテル
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // 「シングル」や「ダブル」という名前を持つTypeモデルへ
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    // この部屋タイプが参照するタイプ（types テーブル）
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    // ★重要：このタイプに属する「実際の部屋」たちを取得する
    public function rooms(): HasMany
    {
        return $this->hasMany(HotelRoom::class, 'type_id', 'type_id')
                    ->where('hotel_id', $this->hotel_id);
    }
}
