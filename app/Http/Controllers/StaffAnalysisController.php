<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\RestaurantReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffAnalysisController extends Controller
{
    public function hotelAnalysis($hotelId = null)
{
    // 1. 月ごとのKPI統計を一括取得 (Bookings, Guests, AvgStay)
    // Model側でgroupBy('month')してkeyBy('month')したもの
    $monthlyKpis = HotelReservation::getMonthlyKpiStats($hotelId);

    // 2. グラフ用のデータ整形（1月〜12月を0埋めで保証）
    $monthlyBookings = [];
    $monthlyGuests   = [];
    $monthlyAvgStay  = [];
    
    for ($m = 1; $m <= 12; $m++) {
        $stat = $monthlyKpis->get($m);
        $monthlyBookings[] = $stat ? $stat->total_bookings : 0;
        $monthlyGuests[]   = $stat ? $stat->total_guests : 0;
        $monthlyAvgStay[]  = $stat ? (float)$stat->avg_stay : 0.0;
    }

    // 3. 売上統計
    $monthlyStats    = HotelReservation::getMonthlyStatsByYear($hotelId);
    $monthlyRevenue  = $monthlyStats['revenue'];

    // 4. その他の統計
    $dayOfWeekData   = HotelReservation::getDayOfWeekComparison($hotelId);
    $typeStatsMonth        = HotelRoomType::getTypeRevenueStats($hotelId, 'month');
    $typeBookingStatsMonth = HotelRoomType::getTypeBookingStats($hotelId, 'month');
    $typeStatsYear         = HotelRoomType::getTypeRevenueStats($hotelId, 'year');
    $typeBookingStatsYear  = HotelRoomType::getTypeBookingStats($hotelId, 'year');

    // --- ヒートマップ用ロジック ---
    $year = now()->year;
    $month = now()->month;
    $daysInMonth = now()->daysInMonth;
    $heatmapData = array_fill(1, $daysInMonth, 0);

    $reservations = HotelReservation::when($hotelId, function($query) use ($hotelId) {
            return $query->where('hotel_id', $hotelId);
        })
        ->where(function($q) {
            $firstDay = now()->startOfMonth();
            $lastDay = now()->endOfMonth();
            $q->whereBetween('start_at', [$firstDay, $lastDay])
              ->orWhereBetween('end_at', [$firstDay, $lastDay])
              ->orWhere(function($sub) use ($firstDay, $lastDay) {
                  $sub->where('start_at', '<=', $firstDay)
                      ->where('end_at', '>=', $lastDay);
              });
        })->get();

    foreach ($reservations as $res) {
        $start = Carbon::parse($res->start_at);
        $end = Carbon::parse($res->end_at);
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->month == $month && $date->year == $year) {
                $heatmapData[$date->day]++;
            }
        }
    }

    $hotels = Hotel::all();

    // 画面上部のカードに表示する「今月のKPI」
    $currentKpi = $monthlyKpis->get(now()->month);

    return view('staffpage.analysis.hotel-analysis', compact(
        'currentKpi', 'monthlyBookings', 'monthlyRevenue', 'monthlyGuests', 'monthlyAvgStay',
        'dayOfWeekData', 'typeStatsMonth', 'typeBookingStatsMonth',
        'typeStatsYear', 'typeBookingStatsYear',
        'hotelId', 'hotels', 'heatmapData'
    ));
}

public function restaurantAnalysis($restaurantId = null)
{
    // 1. 今月のKPI（上部カード用）
    $kpi = RestaurantReservation::getKpiStats($restaurantId); 
    $avgStayTime = RestaurantReservation::getAverageStayTime($restaurantId); 

    // 2. 1年分の月次KPI（表と詳細グラフ用）
    $monthlyKpis = RestaurantReservation::getMonthlyKpiStats($restaurantId);
    
    $monthlyBookings = [];
    $monthlyGuests   = [];
    $monthlyAvgStay  = [];
    
    for ($m = 1; $m <= 12; $m++) {
        $stat = $monthlyKpis->get($m);
        $monthlyBookings[] = $stat ? $stat->total_bookings : 0;
        $monthlyGuests[]   = $stat ? $stat->total_guests : 0;
        $monthlyAvgStay[]  = $stat ? (float)$stat->avg_stay : 0.0;
    }

    // 3. その他の統計
    $hourlyStats = RestaurantReservation::getHourlyStats($restaurantId);
    
    // 日次データ（折れ線グラフ用）
    $year = now()->year;
    $month = now()->month;
    $daysInMonth = now()->daysInMonth;
    $dailyData = array_fill(1, $daysInMonth, 0);
    
    $reservations = RestaurantReservation::whereMonth('reserved_at', $month)
        ->whereYear('reserved_at', $year)
        ->when($restaurantId, function($query) use ($restaurantId) {
            return $query->where('restaurant_id', $restaurantId);
        })->get();

    foreach ($reservations as $res) {
        $day = Carbon::parse($res->reserved_at)->day;
        $dailyData[$day]++;
    }

    $restaurants = Restaurant::all();
    $currentKpi = $monthlyKpis->get(now()->month);

    return view('staffpage.analysis.restaurant-analysis', compact(
        'kpi', 'avgStayTime', 'monthlyBookings', 'monthlyGuests', 'monthlyAvgStay', 
        'dailyData', 'restaurantId', 'restaurants', 'hourlyStats', 'currentKpi'
    ));
}
}