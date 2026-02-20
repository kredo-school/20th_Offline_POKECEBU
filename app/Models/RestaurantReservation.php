<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\Restaurant;
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

    public static function getKpiStats($restaurantId = null)
    {
        $query = self::whereMonth('reserved_at', now()->month)
                     ->whereYear('reserved_at', now()->year);

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        }

        return $query->select(
            DB::raw('COUNT(*) as total_bookings'),
            DB::raw('SUM(guests) as total_guests')
        )->first();
    }

    public static function getAverageStayTime($restaurantId = null)
    {
        $query = self::whereMonth('reserved_at', now()->month)
                     ->whereYear('reserved_at', now()->year)
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
            DB::raw('MONTH(reserved_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('reserved_at', $year)
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

        $results = self::select(
            DB::raw('HOUR(start_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->whereMonth('reserved_at', now()->month)
        ->whereYear('reserved_at', now()->year)
        ->whereNotNull('start_at')
        ->when($restaurantId, function($query) use ($restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();

        foreach ($results as $result) {
            $hourlyData[$result->hour] = $result->count;
        }

        return $hourlyData;
    }

    public static function getMonthlyStatsByYear($restaurantId = null)
{
    $year = now()->year;
    $monthlyBookings = array_fill(0, 12, 0);

    $results = self::select(
        DB::raw('MONTH(restaurant_reservations.created_at) as month'),
        DB::raw('COUNT(*) as count')
    )
    ->join('statuses', 'restaurant_reservations.status_id', '=', 'statuses.id')
    ->whereYear('restaurant_reservations.created_at', $year)
    ->where('statuses.name', 'Booked')
    ->when($restaurantId, function($query) use ($restaurantId) {
        return $query->where('restaurant_id', $restaurantId);
    })
    ->groupBy('month')
    ->get();

    foreach ($results as $result) {
        $monthlyBookings[$result->month - 1] = $result->count;
    }

    return $monthlyBookings; 
}
}