<?php

namespace App\Http\Controllers;

use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\RestaurantReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StaffAnalysisController extends Controller
{
    /**
     * HOTEL ANALYSIS (Staff Side)
     */
        public function hotelAnalysis()
    {
        $hotelId = Auth::id();

        // 1. KPI & 基本統計
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

        // --- ヒートマップ用：全期間の滞在データを集計 ---
        $allDailyData = [];

        $reservations = HotelReservation::where('hotel_id', $hotelId)->get();

        foreach ($reservations as $res) {
            if (!$res->start_at || !$res->end_at) continue;

            $start = Carbon::parse($res->start_at);
            $end = Carbon::parse($res->end_at);

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dateKey = $date->format('Y-m-d');
                $allDailyData[$dateKey] = ($allDailyData[$dateKey] ?? 0) + 1;
            }
        }

        $hotels = Hotel::where('id', $hotelId)->get();
        $currentKpi = $monthlyKpis->get(now()->month);

        $cancelledReservations = HotelReservation::with(['user', 'roomType'])
            ->where('hotel_id', $hotelId)
            ->where('status_id', 5)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('staffpage.analysis.hotel-analysis', compact(
            'currentKpi', 
            'monthlyBookings', 
            'monthlyRevenue', 
            'monthlyGuests', 
            'monthlyAvgStay', 
            'dayOfWeekData', 
            'typeStatsMonth', 
            'typeBookingStatsMonth', 
            'typeStatsYear', 
            'typeBookingStatsYear', 
            'hotelId', 
            'hotels', 
            'allDailyData',
            'cancelledReservations'
        ));
    }

    public function markCancellationsRead()
    {
        session(['last_cancellation_check' => now()]);
        return redirect()->back();
    }
    /**
     * RESTAURANT ANALYSIS (Staff Side)
     */
    public function restaurantAnalysis()
    {
        $restaurantId = Auth::id();

        // 1. KPI & 基本統計の取得
        $kpi = RestaurantReservation::getKpiStats($restaurantId);
        $avgStayTime = RestaurantReservation::getAverageStayTime($restaurantId);
        $monthlyKpis = RestaurantReservation::getMonthlyKpiStats($restaurantId);

        // 月次グラフ用のデータを12ヶ月分用意
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

        // --- ヒートマップ用：全期間の予約データを集計 ---
        $allDailyData = [];

        // 期間制限を完全に撤廃し、該当レストランの全予約を取得
        $rawReservations = RestaurantReservation::where('restaurant_id', $restaurantId)
            ->select('end_at')
            ->get();

        foreach ($rawReservations as $res) {
            if (!$res->end_at) continue;

            // 日付をキーにしてカウント（過去・未来すべての予約が含まれます）
            $dateKey = Carbon::parse($res->end_at)->format('Y-m-d');
            $allDailyData[$dateKey] = ($allDailyData[$dateKey] ?? 0) + 1;
        }

        $restaurants = Restaurant::where('id', $restaurantId)->get();
        $currentKpi = $monthlyKpis->get(now()->month);

        return view('staffpage.analysis.restaurant-analysis', compact(
            'kpi', 
            'avgStayTime', 
            'monthlyBookings', 
            'monthlyGuests', 
            'monthlyAvgStay', 
            'allDailyData', 
            'restaurantId', 
            'restaurants', 
            'hourlyStats', 
            'currentKpi'
        ));
    }
}