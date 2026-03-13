<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RestaurantReservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'restaurant_id',
        'table_id',
        'status_id',
        'reserved_at',
        'start_at',
        'end_at',
        'guests',
        'total_price',
        'other'
    ];

    protected $casts = [
        'reserved_at' =>'datetime',
        'start_at'      => 'datetime',
        'end_at'        => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function table() {
        return $this->belongsTo(RestaurantTable::class,'table_id');
       
    }

    // 1年分をまとめて取得するメソッド
public static function getMonthlyKpiStats($restaurantId = null)
{
    return self::query()
        ->when($restaurantId, function ($query, $restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })
        ->whereYear('end_at', now()->year)
        ->selectRaw('
            MONTH(end_at) as month,
            COUNT(id) as total_bookings, 
            SUM(guests) as total_guests,
            AVG(TIMESTAMPDIFF(MINUTE, start_at, end_at)) as avg_stay
        ')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');
}

// 今月分だけを取得するメソッド（コントローラーの91行目で呼ばれているもの）
public static function getKpiStats($restaurantId = null)
{
    return self::query()
        ->when($restaurantId, function ($query, $restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })
        ->whereMonth('end_at', now()->month)
        ->whereYear('end_at', now()->year)
        ->selectRaw('
            COUNT(id) as total_bookings, 
            SUM(guests) as total_guests
        ')
        ->first();
}
    public static function getAverageStayTime($restaurantId = null)
    {
        $query = self::whereMonth('end_at', now()->month)
                     ->whereYear('end_at', now()->year)
                     ->whereNotNull('start_at')
                     ->whereNotNull('end_at');

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        // TIMESTAMPDIFF を使って分単位の差分を取得し、その平均を出す
        $averageMinutes = $query->select(
            DB::raw('AVG(TIMESTAMPDIFF(MINUTE, start_at, end_at)) as avg_time')
        )->value('avg_time');

        return round($averageMinutes ?? 0);
    }

    public static function getMonthlyBookingsByYear($restaurantId = null)
    {
        $year = now()->year;
        $monthlyData = array_fill(0, 12, 0);

        $results = self::select(
            DB::raw('MONTH(end_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('end_at', $year)
        ->when($restaurantId, function($query) use ($restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })
        ->groupBy('month')
        ->get();

        foreach ($results as $result) {
            $monthlyData[$result->month - 1] = $result->count;
        }

        return $monthlyData;
    }
    
public static function getHourlyStats($restaurantId = null)
{
    $hourlyData = array_fill(0, 24, 0);

    $reservations = self::whereMonth('end_at', now()->month)
        ->whereYear('end_at', now()->year)
        ->whereNotNull('start_at')
        ->whereNotNull('end_at')
        ->when($restaurantId, function ($query) use ($restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })
        ->get();

    foreach ($reservations as $reservation) {
        $start = Carbon::parse($reservation->start_at)->copy();
        $end   = Carbon::parse($reservation->end_at)->copy();

        // 1時間ごとに加算
        while ($start <= $end) {
            $hour = $start->hour;
            $hourlyData[$hour]++;
            $start->addHour();
        }
    }

    return $hourlyData;
}

}