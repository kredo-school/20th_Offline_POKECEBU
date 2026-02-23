<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HotelReservation;
use App\Models\RestaurantReservation;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now();

        /*
        |--------------------------------------------------------------------------
        | Hotel Reservations
        |--------------------------------------------------------------------------
        */
        $hotelReservations = HotelReservation::where('user_id', $user->id)
            ->orderBy('start_at', 'asc')
            ->get();

        $upcomingHotels = $hotelReservations->filter(function ($res) use ($today) {
            return $res->status_id == 0 && $res->start_at >= $today;
        });

        $pastHotels = $hotelReservations->filter(function ($res) use ($today) {
            return $res->status_id == 1 || ($res->status_id == 0 && $res->end_at < $today);
        });

        $cancelledHotels = $hotelReservations->filter(function ($res) {
            return $res->status_id == 2;
        });

        /*
        |--------------------------------------------------------------------------
        | Restaurant Reservations
        |--------------------------------------------------------------------------
        */
        $restaurantReservations = RestaurantReservation::where('user_id', $user->id)
            ->orderBy('start_at', 'asc')
            ->get();

        $upcomingRestaurants = $restaurantReservations->filter(function ($res) use ($today) {
            return $res->status_id == 0 && $res->start_at >= $today;
        });

        $pastRestaurants = $restaurantReservations->filter(function ($res) use ($today) {
            return $res->status_id == 1 || ($res->status_id == 0 && $res->start_at < $today);
        });

        $cancelledRestaurants = $restaurantReservations->filter(function ($res) {
            return $res->status_id == 2;
        });

        return view('userpage.mypage.booking', compact(
            'upcomingHotels',
            'pastHotels',
            'cancelledHotels',
            'upcomingRestaurants',
            'pastRestaurants',
            'cancelledRestaurants'
        ));
    }
}
