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
    // 1. 基本統計
    $kpi             = HotelReservation::getKpiStats($hotelId);
    $avgStay         = HotelReservation::getAverageStay($hotelId);
    
    // 月別統計（予約数と売上の両方を取得）
    $monthlyStats    = HotelReservation::getMonthlyStatsByYear($hotelId);
    $monthlyBookings = $monthlyStats['bookings'];
    $monthlyRevenue  = $monthlyStats['revenue']; // これをビューに渡す必要があります

    $dayOfWeekData   = HotelReservation::getDayOfWeekComparison($hotelId);

    // ルームタイプ別統計
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
        ->where(function($q) use ($year, $month) {
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

    return view('staffpage.analysis.hotel-analysis', compact(
        'kpi', 'monthlyBookings', 'monthlyRevenue', 'avgStay', 'dayOfWeekData',
        'typeStatsMonth', 'typeBookingStatsMonth',
        'typeStatsYear', 'typeBookingStatsYear',
        'hotelId', 'hotels', 'heatmapData'
    ));
}


public function restaurantAnalysis($restaurantId = null)
{
    $kpi = RestaurantReservation::getKpiStats($restaurantId); 
    $avgStayTime = RestaurantReservation::getAverageStayTime($restaurantId); 
    $monthlyBookings = RestaurantReservation::getMonthlyBookingsByYear($restaurantId);
    $hourlyStats = RestaurantReservation::getHourlyStats($restaurantId);
    $monthlyBookings = RestaurantReservation::getMonthlyStatsByYear($restaurantId);
    
    // 日次データ（棒グラフ用）
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

    return view('staffpage.analysis.restaurant-analysis', compact(
        'kpi', 'avgStayTime', 'monthlyBookings', 'dailyData', 'restaurantId', 'restaurants','hourlyStats','monthlyBookings'
    ));
}
}