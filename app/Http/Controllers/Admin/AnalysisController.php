<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelReservation;
use App\Models\RestaurantReservation;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
public function hotelAnalysis()
{
    $currentMonth = now()->month;

    // 1. KPI: 今月の顧客数と売上
    $kpi = HotelReservation::whereMonth('created_at', $currentMonth)
        ->where('status_id', '2') // 確定済み予約のみ ステータスに合わせて変更
        ->selectRaw('COUNT(id) as customers, SUM(total_price) as sales')
        ->first();

    // 2. Bar Chart: 月別予約件数 (1月〜12月)
    $monthlyBookings = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyBookings[] = HotelReservation::whereMonth('created_at', $i)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    return view('adminpage.hotel.analysis-hotel', compact('kpi', 'monthlyBookings'));
}
public function restaurantAnalysis()
{
    $currentMonth = now()->month;

    // 1. KPI: 今月の顧客数と売上
    $kpi = RestaurantReservation::whereMonth('created_at', $currentMonth)
        ->where('status_id', '2') // 確定済み予約のみ ステータスに合わせて変更
        ->selectRaw('COUNT(id) as customers, SUM(total_price) as sales')
        ->first();

    // 2. Bar Chart: 月別予約件数 (1月〜12月)
    $monthlyBookings = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyBookings[] = RestaurantReservation::whereMonth('created_at', $i)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    return view('adminpage.restaurant.analysis-restaurant', compact('kpi', 'monthlyBookings'));
}

}
