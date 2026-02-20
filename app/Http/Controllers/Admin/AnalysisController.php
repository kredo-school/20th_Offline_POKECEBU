<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\RestaurantReservation;

class AnalysisController extends Controller
{
   public function hotelAnalysis($hotelId = null)
{
    // 1. 基本統計 (既存)
    $kpi             = HotelReservation::getKpiStats($hotelId);
    $avgStay         = HotelReservation::getAverageStay($hotelId);
    $monthlyBookings = HotelReservation::getMonthlyBookingsByYear($hotelId);
    $dayOfWeekData   = HotelReservation::getDayOfWeekComparison($hotelId);

    // 【今月分】
    $typeStatsMonth = HotelRoomType::getTypeRevenueStats($hotelId, 'month');
    $typeBookingStatsMonth = HotelRoomType::getTypeBookingStats($hotelId, 'month');

    // 【今年分】
    $typeStatsYear = HotelRoomType::getTypeRevenueStats($hotelId, 'year');
    $typeBookingStatsYear = HotelRoomType::getTypeBookingStats($hotelId, 'year');

    $hotels = Hotel::all();

    return view('adminpage.hotel.analysis-hotel', compact(
        'kpi', 
        'monthlyBookings', 
        'avgStay', 
        'dayOfWeekData',
        'typeStatsMonth', 'typeBookingStatsMonth',
        'typeStatsYear', 'typeBookingStatsYear',
        'hotelId',
        'hotels'
    ));
}

    public function restaurantAnalysis()
    {
        $currentMonth = now()->month;

        // 1. KPI: 今月の顧客数と売上
        $kpi = RestaurantReservation::whereMonth('created_at', $currentMonth)
            ->where('status_id', '2')
            ->selectRaw('COUNT(id) as customers, SUM(total_price) as sales')
            ->first();

        // 2. Bar Chart: 月別予約件数
        $monthlyBookings = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyBookings[] = RestaurantReservation::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->where('status_id', '2')
                ->count();
        }

        // 3. Line Chart: 曜日別予約数
        $dayOfWeekData = [];
        $days = [2, 3, 4, 5, 6, 7, 1]; // Mon -> Sun
        foreach ($days as $day) {
            $dayOfWeekData[] = RestaurantReservation::whereRaw("DAYOFWEEK(created_at) = ?", [$day])
                ->where('status_id', '2')
                ->count();
        }

        // 4. Doughnut Chart: テーブルタイプ別売上
        $typeStats = RestaurantReservation::query()
            ->join('restaurant_tables', 'restaurant_reservations.table_id', '=', 'restaurant_tables.id')
            ->join('table_type', 'restaurant_tables.type_id', '=', 'table_type.id')
            ->where('restaurant_reservations.status_id', '2')
            ->groupBy('table_type.name')
            ->selectRaw('table_type.name, SUM(restaurant_reservations.total_price) as total_sales')
            ->get();

        $typeLabels = $typeStats->pluck('name');
        $typeRevenue = $typeStats->pluck('total_sales');

        return view('adminpage.restaurant.analysis-restaurant', compact(
            'kpi', 
            'monthlyBookings', 
            'dayOfWeekData', 
            'typeLabels', 
            'typeRevenue'
        ));
    }
}