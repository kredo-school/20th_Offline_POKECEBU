<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class HotelReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_id',       // 必要に応じて
        'user_name',
        'user_email',
        'user_phone',
        'checkin_date',
        'checkout_date',
        'guests',
        'status',        // 未払い, 確定
        'price_total',
            'other', 
    ];

    protected $casts = [
        'reserved_at'   => 'datetime',
        'start_at'      => 'datetime',
        'end_at'        => 'datetime'
    ];

    // どのホテルの予約か
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }


    // ユーザーとの関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // どの部屋の予約か（必要に応じて）
    public function room()
    {
        return $this->belongsTo(HotelRoom::class, 'room_id');
    }

public static function getKpiStats($hotelId = null, $month = null)
{
    $targetMonth = $month ?? now()->month;

    return self::query()
        ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
        ->when($hotelId, function ($query, $hotelId) {
            return $query->where('hotel_reservations.hotel_id', $hotelId);
        })
        ->whereMonth('hotel_reservations.created_at', $targetMonth)
        ->whereYear('hotel_reservations.created_at', now()->year)
        ->where('statuses.name', 'Booked')
        ->selectRaw('COUNT(hotel_reservations.id) as customers, SUM(hotel_reservations.total_price) as sales')
        ->first();
}

public static function getAverageStay($hotelId = null)
{
    return self::query()
        ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
        ->when($hotelId, function ($query, $hotelId) {
            return $query->where('hotel_reservations.hotel_id', $hotelId);
        })
        ->where('statuses.name', 'Booked')
        ->avg(DB::raw('DATEDIFF(hotel_reservations.end_at, hotel_reservations.start_at)')) ?? 0;
}

public static function getMonthlyBookingsByYear($hotelId = null, $year = null)
{
    $year = $year ?? now()->year;
    $data = [];

    for ($i = 1; $i <= 12; $i++) {
        $data[] = self::query()
            ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
            ->when($hotelId, function ($query, $hotelId) {
                return $query->where('hotel_reservations.hotel_id', $hotelId);
            })
            ->where('statuses.name', 'Booked')
            ->whereMonth('hotel_reservations.start_at', $i)
            ->whereYear('hotel_reservations.start_at', $year)
            ->count('hotel_reservations.id');
    }
    return $data;
}

public static function getDayOfWeekStats($hotelId = null)
{
    $days = [2, 3, 4, 5, 6, 7, 1]; // 月〜日
    $thisWeekData = [];
    $allTimeAverage = [];

    // 今週の範囲
    $startOfWeek = now()->startOfWeek();
    $endOfWeek   = now()->endOfWeek();

    // 過去のデータの期間（週数）を取得して平均を出すため
    $totalWeeks = self::query()
        ->where('start_at', '<', $startOfWeek)
        ->selectRaw('DATEDIFF(MAX(start_at), MIN(start_at)) / 7 as weeks')
        ->value('weeks') ?: 1;

    foreach ($days as $day) {
        // ① 今週のデータ
        $thisWeekData[] = self::query()
            ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
            ->when($hotelId, function ($query, $hotelId) {
                return $query->where('hotel_reservations.hotel_id', $hotelId);
            })
            ->whereBetween('hotel_reservations.start_at', [$startOfWeek, $endOfWeek])
            ->whereRaw("DAYOFWEEK(hotel_reservations.start_at) = ?", [$day])
            ->where('statuses.name', 'Booked')
            ->count('hotel_reservations.id');

        // ② 過去すべての平均データ
        $totalCount = self::query()
            ->join('statuses', 'hotel_reservations.status_id', '=', 'statuses.id')
            ->when($hotelId, function ($query, $hotelId) {
                return $query->where('hotel_reservations.hotel_id', $hotelId);
            })
            ->where('hotel_reservations.start_at', '<', $startOfWeek)
            ->whereRaw("DAYOFWEEK(hotel_reservations.start_at) = ?", [$day])
            ->where('statuses.name', 'Booked')
            ->count('hotel_reservations.id');
        
        $allTimeAverage[] = round($totalCount / $totalWeeks, 1);
    }

    return [
        'thisWeek' => $thisWeekData,
        'average'  => $allTimeAverage
    ];
}
}
