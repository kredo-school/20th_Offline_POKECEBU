<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\RestaurantReservation;
use Carbon\Carbon;

class RestaurantStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-restaurant');
    }

    // カレンダー
    public function calendar()
    {
        return view('staffpage.calendar.restaurant-calendar');
    }

    public function calendarData()
    {
        $restaurantId = Auth::id();
        $reservations = RestaurantReservation::where('restaurant_id', $restaurantId)
            ->select(
                DB::raw('DATE(start_at) as date'),
                DB::raw('HOUR(start_at) as hour'),
                DB::raw('COUNT(*) as groups'),
                DB::raw('SUM(guests) as total_guests')
            )
            ->groupBy(
                DB::raw('DATE(start_at)'),
                DB::raw('HOUR(start_at)')
            )
            ->get();

        $events = [];
        foreach ($reservations as $reservation) {

            $start = Carbon::parse($reservation->date . ' ' . $reservation->hour . ':00');

            $events[] = [
                'title'     => $reservation->groups . 'groups / ' . $reservation->total_guests . 'guests',
                'start' => $start->toIso8601String(),
                'end'   => $start->copy()->addHour()->toIso8601String(),
                'url'   => route('restaurant.reservations.date', [
                    'date' => $reservation->date
                ]),
            ];
        }
        return response()->json($events);
    }

    // 予約一覧（日付ごと）
    public function daily($date)
    {
        $date = Carbon::parse($date);
        $reservations = RestaurantReservation::where('restaurant_id', Auth::id())
            ->whereDate('start_at', $date)
            ->orderBy('start_at')
            ->get();

        return view('staffpage.reservations.restaurant-index', compact('reservations', 'date'));
    }

    // 予約詳細
    public function show($id)
    {
        $reservation = RestaurantReservation::with([
            'user.detail'

        ])
            ->where('restaurant_id', Auth::id())
            ->findOrFail($id);

        return view(
            'staffpage.reservations.restaurant-detail',
            compact('reservation')
        );
    }
}
