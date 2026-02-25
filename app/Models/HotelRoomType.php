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
                    ->whereColumn('hotel_rooms.hotel_id','hotel_room_types.hotel_id');
    }
    public static function getTypeRevenueStats($hotelId = null, $period = 'month')
{
    // ★ self::query() ではなく HotelReservation::query() から始める
    return \App\Models\HotelReservation::query()
        ->join('hotel_rooms', 'hotel_reservations.room_id', '=', 'hotel_rooms.id')
        ->join('types', 'hotel_rooms.type_id', '=', 'types.id')
        ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
        ->when($hotelId, function ($query, $hotelId) {
            return $query->where('hotel_reservations.hotel_id', $hotelId);
        })
        ->where('statuses.name', 'Booked')
        ->when($period === 'month', function ($query) {
            return $query->whereMonth('hotel_reservations.created_at', now()->month)
                         ->whereYear('hotel_reservations.created_at', now()->year);
        })
        ->when($period === 'year', function ($query) {
            return $query->whereYear('hotel_reservations.created_at', now()->year);
        })
        ->groupBy('types.name')
        // これで hotel_reservations.total_price が正しく認識されます
        ->selectRaw('types.name as label_name, SUM(hotel_reservations.total_price) as total_sales')
        ->get();
}

public static function getTypeBookingStats($hotelId = null, $period = 'month')
{
    // こちらも同様に HotelReservation からスタート
    return \App\Models\HotelReservation::query()
        ->join('hotel_rooms', 'hotel_reservations.room_id', '=', 'hotel_rooms.id')
        ->join('types', 'hotel_rooms.type_id', '=', 'types.id')
        ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
        ->when($hotelId, function ($query, $hotelId) {
            return $query->where('hotel_reservations.hotel_id', $hotelId);
        })
        ->where('statuses.name', 'Booked')
        ->when($period === 'month', function ($query) {
            return $query->whereMonth('hotel_reservations.created_at', now()->month)
                         ->whereYear('hotel_reservations.created_at', now()->year);
        })
        ->when($period === 'year', function ($query) {
            return $query->whereYear('hotel_reservations.created_at', now()->year);
        })
        ->groupBy('types.name')
        ->selectRaw('types.name as label_name, COUNT(hotel_reservations.id) as booking_count')
        ->get();
}
}
