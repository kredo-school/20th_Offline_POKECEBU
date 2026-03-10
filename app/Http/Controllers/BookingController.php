<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HotelReservation;
use App\Models\RestaurantReservation;
use Carbon\Carbon;

class BookingController extends Controller
{
   public function index()
{
    $user = Auth::user();
    // 比較のためにCarbonオブジェクトをそのまま使う（Carbon同士の比較が一番安全）
    $today = now()->startOfDay(); 

    // --- HOTEL ---
    $hotelReservations = HotelReservation::where('user_id', $user->id)
        ->orderBy('start_at', 'asc')
        ->get();

    $upcomingHotels = $hotelReservations->filter(function ($res) use ($today) {
        // status_id が 1 (Active) かつ、終了日が今日以降
        return $res->status_id == 3 && \Carbon\Carbon::parse($res->end_at)->startOfDay() >= $today;
    });

    $pastHotels = $hotelReservations->filter(function ($res) use ($today) {
        // status_id が 1 だが終了日が過ぎている、または完了ステータス(仮に4とするなら)
        return ($res->status_id == 3 && \Carbon\Carbon::parse($res->end_at)->startOfDay() < $today);
    });

    $cancelledHotels = $hotelReservations->filter(function ($res) {
        // status_id が 3 (Cancelled)
        return $res->status_id == 5;
    });

    // --- RESTAURANT ---
    $restaurantReservations = RestaurantReservation::where('user_id', $user->id)
        ->orderBy('start_at', 'asc')
        ->get();

    $upcomingRestaurants = $restaurantReservations->filter(function ($res) use ($today) {
        return $res->status_id == 3 && \Carbon\Carbon::parse($res->start_at)->startOfDay() >= $today;
    });

    $pastRestaurants = $restaurantReservations->filter(function ($res) use ($today) {
        return ($res->status_id == 3 && \Carbon\Carbon::parse($res->start_at)->startOfDay() < $today);
    });

    $cancelledRestaurants = $restaurantReservations->filter(function ($res) {
        return $res->status_id == 5;
    });
    $user = Auth::user()->load('detail'); // ← loadを追加

    return view('userpage.mypage.booking', compact(
    'user', // ← これを追加
    'upcomingHotels', 'pastHotels', 'cancelledHotels',
    'upcomingRestaurants', 'pastRestaurants', 'cancelledRestaurants'
));
}
}