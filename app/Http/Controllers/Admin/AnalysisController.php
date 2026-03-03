<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\Restaurant;
use App\Models\RestaurantReservation;
use App\Models\User;
use Carbon\Carbon;

class AnalysisController extends Controller
{
public function userAnalysis()
{
    // 1. 全一般ユーザー数 (Role 1)
    $totalUsers = User::where('role_id', 1)->count();
    
    // 2. 今月の新規登録者数
    $newThisMonth = User::where('role_id', 1)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    // 3. 過去12ヶ月の登録推移
    $monthlyUserStats = collect();
    $monthLabels = [];
    $growthData = [];

    $rawStats = User::where('role_id', 1)
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as signups")
        ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
        ->groupBy('month_key')
        ->orderBy('month_key')
        ->get()
        ->keyBy('month_key');

    for ($i = 11; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $keyMonth = $month->format('Y-m');
        $count = $rawStats->get($keyMonth)->signups ?? 0;

        $monthlyUserStats->push((object)[
            'month_name' => $month->format('M Y'),
            'signups' => $count
        ]);
        $monthLabels[] = $month->format('M');
        $growthData[] = $count;
    }

    // 4. 【新指標】予約アクティビティ率 (モデルのリレーションを利用)
    // hotelReservations または restaurantReservations を持っているユーザーを抽出
    $activeUsersCount = User::where('role_id', 1)
        ->where(function($query) {
            $query->has('hotelReservations')
                  ->orHas('restaurantReservations');
        })->count();

    $inactiveUsersCount = max(0, $totalUsers - $activeUsersCount);

    $activityData = [
        'active' => $activeUsersCount,
        'inactive' => $inactiveUsersCount
    ];

    return view('adminpage.analysis.user', compact(
        'totalUsers', 
        'newThisMonth', 
        'growthData', 
        'monthLabels', 
        'monthlyUserStats',
        'activityData'
    ));
}

 public function hotelAnalysis($hotelId = null)
{
    $monthlyKpis = HotelReservation::getMonthlyKpiStats($hotelId);

    $monthlyBookings = [];
    $monthlyGuests   = [];
    $monthlyAvgStay  = [];
    
    for ($m = 1; $m <= 12; $m++) {
        $stat = $monthlyKpis->get($m);
        $monthlyBookings[] = $stat ? $stat->total_bookings : 0;
        $monthlyGuests[]   = $stat ? $stat->total_guests : 0;
        $monthlyAvgStay[]  = $stat ? (float)$stat->avg_stay : 0.0;
    }

    $monthlyStats    = HotelReservation::getMonthlyStatsByYear($hotelId);
    $monthlyRevenue  = $monthlyStats['revenue'];

    $dayOfWeekData   = HotelReservation::getDayOfWeekComparison($hotelId);
    $typeStatsMonth        = HotelRoomType::getTypeRevenueStats($hotelId, 'month');
    $typeBookingStatsMonth = HotelRoomType::getTypeBookingStats($hotelId, 'month');
    $typeStatsYear         = HotelRoomType::getTypeRevenueStats($hotelId, 'year');
    $typeBookingStatsYear  = HotelRoomType::getTypeBookingStats($hotelId, 'year');

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

    $currentKpi = $monthlyKpis->get(now()->month);

    return view('adminpage.analysis.hotel', compact(
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

    return view('adminpage.analysis.restaurant', compact(
        'kpi', 'avgStayTime', 'monthlyBookings', 'monthlyGuests', 'monthlyAvgStay', 
        'dailyData', 'restaurantId', 'restaurants', 'hourlyStats', 'currentKpi'
    ));
}
}