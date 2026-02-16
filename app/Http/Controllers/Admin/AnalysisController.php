<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\RestaurantReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
public function hotelAnalysis($hotelId = null)
{
    $kpi             = HotelReservation::getKpiStats($hotelId);
    $avgStay         = HotelReservation::getAverageStay($hotelId);
    $monthlyBookings = HotelReservation::getMonthlyBookingsByYear($hotelId);
    $dayOfWeekData   = HotelReservation::getDayOfWeekStats($hotelId);

    $typeStats   = HotelRoomType::getTypeRevenueStats($hotelId);
    $typeLabels  = $typeStats->pluck('label_name');
    $typeRevenue = $typeStats->pluck('total_sales');

    $typeBookingStats  = HotelRoomType::getTypeBookingStats($hotelId);    
    $typeBookingLabels = $typeBookingStats->pluck('label_name');
    $typeBookingCounts = $typeBookingStats->pluck('booking_count');

    return view('adminpage.hotel.analysis-hotel', compact(
        'kpi', 
        'monthlyBookings', 
        'avgStay', 
        'dayOfWeekData', 
        'typeLabels', 
        'typeRevenue',
        'typeBookingLabels',
        'typeBookingCounts',
        'hotelId' 
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