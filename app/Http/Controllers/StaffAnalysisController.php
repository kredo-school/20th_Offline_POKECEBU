<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HotelReservation;
use App\Models\HotelRoomType;
use App\Models\Hotel;
use Illuminate\Http\Request;

class StaffAnalysisController extends Controller
{
    public function hotelAnalysis($hotelId = null)
{
    // 1. KPI・基本統計の取得
    $kpi             = HotelReservation::getKpiStats($hotelId);
    $avgStay         = HotelReservation::getAverageStay($hotelId);
    $monthlyBookings = HotelReservation::getMonthlyBookingsByYear($hotelId);
    
    // ★ ここを「今週 vs 過去平均」を返すメソッドに差し替え
    $dayOfWeekData   = HotelReservation::getDayOfWeekStats($hotelId);

    // 2. ルームタイプ別 売上統計
    $typeStats   = HotelRoomType::getTypeRevenueStats($hotelId);
    $typeLabels  = $typeStats->pluck('label_name');
    $typeRevenue = $typeStats->pluck('total_sales');

    // 3. ルームタイプ別 予約数統計
    $typeBookingStats  = HotelRoomType::getTypeBookingStats($hotelId);    
    $typeBookingLabels = $typeBookingStats->pluck('label_name');
    $typeBookingCounts = $typeBookingStats->pluck('booking_count');

    // ホテルのリスト
    $hotels = Hotel::all();

    return view('staffpage.analysis.hotel-analysis', compact(
        'kpi', 
        'monthlyBookings', 
        'avgStay', 
        'dayOfWeekData',
        'typeLabels', 
        'typeRevenue',
        'typeBookingLabels',
        'typeBookingCounts',
        'hotels',
        'hotelId'
    ));

    }
}