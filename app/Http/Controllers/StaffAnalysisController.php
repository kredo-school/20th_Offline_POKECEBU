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

    return view('staffpage.analysis.hotel-analysis', compact(
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
}