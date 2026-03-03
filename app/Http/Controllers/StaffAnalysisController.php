<?php

namespace App\Http\Controllers;

use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\RestaurantReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAnalysisController extends Controller
{
    /**
     * HOTEL ANALYSIS (Staff Side)
     */
   public function hotelAnalysis()
{
    $hotelId = Auth::id();

    $monthlyKpis = HotelReservation::getMonthlyKpiStats($hotelId);

    $monthlyBookings = [];
    $monthlyGuests = [];
    $monthlyAvgStay = [];
    for ($m = 1; $m <= 12; $m++) {
        $stat = $monthlyKpis->get($m);
        $monthlyBookings[] = $stat ? $stat->total_bookings : 0;
        $monthlyGuests[] = $stat ? $stat->total_guests : 0;
        $monthlyAvgStay[] = $stat ? (float)$stat->avg_stay : 0.0;
    }

    $monthlyStats = HotelReservation::getMonthlyStatsByYear($hotelId);
    $monthlyRevenue = $monthlyStats['revenue'];

    $dayOfWeekData = HotelReservation::getDayOfWeekComparison($hotelId);
    $typeStatsMonth = HotelRoomType::getTypeRevenueStats($hotelId, 'month');
    $typeBookingStatsMonth = HotelRoomType::getTypeBookingStats($hotelId, 'month');
    $typeStatsYear = HotelRoomType::getTypeRevenueStats($hotelId, 'year');
    $typeBookingStatsYear = HotelRoomType::getTypeBookingStats($hotelId, 'year');

    // --- ヒートマップ用：過去12ヶ月分の全滞在データを集計 ---
    $allDailyData = [];
    $startDate = now()->subMonths(11)->startOfMonth();
    $endDate = now()->endOfMonth();

    $reservations = HotelReservation::where('hotel_id', $hotelId)
        ->where(function($q) use ($startDate, $endDate) {
            $q->whereBetween('start_at', [$startDate, $endDate])
              ->orWhereBetween('end_at', [$startDate, $endDate]);
        })->get();

    foreach ($reservations as $res) {
        $start = Carbon::parse($res->start_at);
        $end = Carbon::parse($res->end_at);
        // 滞在期間中の各日をカウント
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            // 取得範囲内の日付のみカウント
            if ($date->between($startDate, $endDate)) {
                $dateKey = $date->format('Y-m-d');
                $allDailyData[$dateKey] = ($allDailyData[$dateKey] ?? 0) + 1;
            }
        }
    }

    $hotels = Hotel::where('id', $hotelId)->get();
    $currentKpi = $monthlyKpis->get(now()->month);

    return view('staffpage.analysis.hotel-analysis', compact(
        'currentKpi', 'monthlyBookings', 'monthlyRevenue', 'monthlyGuests', 
        'monthlyAvgStay', 'dayOfWeekData', 'typeStatsMonth', 
        'typeBookingStatsMonth', 'typeStatsYear', 'typeBookingStatsYear', 
        'hotelId', 'hotels', 'allDailyData' // heatmapDataの代わりにallDailyDataを渡す
    ));
}
    /**
     * RESTAURANT ANALYSIS (Staff Side)
     */
    public function restaurantAnalysis()
{
    $restaurantId = Auth::id();

    $kpi = RestaurantReservation::getKpiStats($restaurantId);
    $avgStayTime = RestaurantReservation::getAverageStayTime($restaurantId);
    $monthlyKpis = RestaurantReservation::getMonthlyKpiStats($restaurantId);

    $monthlyBookings = [];
    $monthlyGuests = [];
    $monthlyAvgStay = [];
    for ($m = 1; $m <= 12; $m++) {
        $stat = $monthlyKpis->get($m);
        $monthlyBookings[] = $stat ? $stat->total_bookings : 0;
        $monthlyGuests[] = $stat ? $stat->total_guests : 0;
        $monthlyAvgStay[] = $stat ? (float)$stat->avg_stay : 0.0;
    }

    $hourlyStats = RestaurantReservation::getHourlyStats($restaurantId);

    // --- ヒートマップ用：過去12ヶ月分の日別データを全て取得 ---
    $allDailyData = [];
    $rawReservations = RestaurantReservation::where('restaurant_id', $restaurantId)
        ->where('reserved_at', '>=', now()->subMonths(11)->startOfMonth())
        ->select('reserved_at')
        ->get();

    foreach ($rawReservations as $res) {
        $dateKey = Carbon::parse($res->reserved_at)->format('Y-m-d');
        if (!isset($allDailyData[$dateKey])) {
            $allDailyData[$dateKey] = 0;
        }
        $allDailyData[$dateKey]++;
    }

    $restaurants = Restaurant::where('id', $restaurantId)->get();
    $currentKpi = $monthlyKpis->get(now()->month);

    return view('staffpage.analysis.restaurant-analysis', compact(
        'kpi', 
        'avgStayTime', 
        'monthlyBookings', 
        'monthlyGuests', 
        'monthlyAvgStay', 
        'allDailyData', // 1ヶ月分(dailyData)から全データ(allDailyData)に変更
        'restaurantId', 
        'restaurants', 
        'hourlyStats', 
        'currentKpi'
    ));
}
    
}