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

        // ヒートマップ生成
        $year = now()->year;
        $month = now()->month;
        $daysInMonth = now()->daysInMonth;
        $heatmapData = array_fill(1, $daysInMonth, 0);

        $reservations = HotelReservation::where('hotel_id', $hotelId)
            ->where(function($q) {
                $firstDay = now()->startOfMonth();
                $lastDay = now()->endOfMonth();
                $q->whereBetween('start_at', [$firstDay, $lastDay])
                  ->orWhereBetween('end_at', [$firstDay, $lastDay]);
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

        // スタッフ側では「全てのホテル」を選ぶ必要はないので、単一の自ホテルのみ
        $hotels = Hotel::where('id', $hotelId)->get();
        $currentKpi = $monthlyKpis->get(now()->month);

        return view('staffpage.analysis.hotel-analysis', compact(
            'currentKpi', 'monthlyBookings', 'monthlyRevenue', 'monthlyGuests', 
            'monthlyAvgStay', 'dayOfWeekData', 'typeStatsMonth', 
            'typeBookingStatsMonth', 'typeStatsYear', 'typeBookingStatsYear', 
            'hotelId', 'hotels', 'heatmapData'
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

        // 日次予約データ
        $year = now()->year;
        $month = now()->month;
        $daysInMonth = now()->daysInMonth;
        $dailyData = array_fill(1, $daysInMonth, 0);

        $reservations = RestaurantReservation::where('restaurant_id', $restaurantId)
            ->whereMonth('reserved_at', $month)
            ->whereYear('reserved_at', $year)
            ->get();

        foreach ($reservations as $res) {
            $day = Carbon::parse($res->reserved_at)->day;
            $dailyData[$day]++;
        }

        $restaurants = Restaurant::where('id', $restaurantId)->get();
        $currentKpi = $monthlyKpis->get(now()->month);

        return view('staffpage.analysis.restaurant-analysis', compact(
            'kpi', 'avgStayTime', 'monthlyBookings', 'monthlyGuests', 
            'monthlyAvgStay', 'dailyData', 'restaurantId', 'restaurants', 
            'hourlyStats', 'currentKpi'
        ));
    }
}