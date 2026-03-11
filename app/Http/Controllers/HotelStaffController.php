<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HotelRoom;
use App\Models\HotelReservation;
use App\Models\Reservation;
use Carbon\Carbon;

class HotelStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-hotel');
    }

    public function reservations()
    {
        $reservations = Reservation::with('guest', 'room')->get();
        return view('staff.reservations.index', compact('reservations'));
    }


    public function showhotel()
    {
        return view('staffpage.edit-hotel');
    }

    public function editHotel() {}

    public function showrestaurant()
    {
        return view('staffpage.edit-restaurant');
    }

    // カレンダー
    public function calendar()
    {
        return view('staffpage.calendar.hotel-calendar');
    }

    public function calendarData()
    {

        $hotelId = Auth::id();

        $reservations = HotelReservation::where('hotel_id', $hotelId)
            ->get();
        $totalRooms = HotelRoom::where('hotel_id', $hotelId)->count();

        $days = [];

        foreach ($reservations as $reservation) {

            $start = Carbon::parse($reservation->start_at);
            $end = Carbon::parse($reservation->end_at);

            while ($start->lt($end)) {
                $date = $start->toDateString();

                if (!isset($days[$date])) {
                    $days[$date] = [
                        'rooms'     => 0,
                        'guests'    => 0,
                        'checkins'  => 0,
                        'checkouts' => 0
                    ];
                }

                $days[$date]['rooms'] += 1;
                $days[$date]['guests'] += $reservation->guests;

                $start->addDay();
            }
            // チェックイン
            $checkinDate = Carbon::parse($reservation->start_at)->toDateString();
            if (isset($days[$checkinDate])) {
                $days[$checkinDate]['checkins'] += 1;
            }
            // チェックアウト
            $checkoutDate = Carbon::parse($reservation->end_at)->toDateString();
            if (isset($days[$checkoutDate])) {
                $days[$checkoutDate]['checkouts'] += 1;
            }
        }

        $events = [];
        foreach ($days as $date => $data) {
            $events[] = [

                'start' => $date,
                'extendedProps' => [
                    'rooms'     => $data['rooms'],
                    'guests'    => $data['guests'],
                    'capacity' => $totalRooms,
                    'checkins' => $data['checkins'],
                    'checkouts' => $data['checkouts']
                ],
                'url' => route('hotel.reservations.date', [
                    'date' => $date
                ])
            ];
        }

        return response()->json($events);
    }

    // 予約一覧（日付ごと）
    public function daily($date)
    {
        $date = Carbon::parse($date);
        $reservations = HotelReservation::where('hotel_id', Auth::id())
            ->whereDate('start_at', '<=', $date)
            ->whereDate('end_at', '>', $date)
            ->orderBy('start_at')
            ->get();

        return view('staffpage.reservations.hotel-index', compact('reservations', 'date'));
    }

    // 予約詳細
    public function show($id)
    {
        $reservation = HotelReservation::with([
            'user.detail',
            'room'
        ])
            ->where('hotel_id', Auth::id())
            ->findOrFail($id);

        return view(
            'staffpage.reservations.hotel-detail',
            compact('reservation')
        );
    }
}
