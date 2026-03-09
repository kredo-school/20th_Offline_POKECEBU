<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
    public function calendar() {
        return view('staffpage.calendar.restaurant-calendar');       
    }

    public function calendarData() {
        $reservations = RestaurantReservation::select('start_at','end_at','guests')->get();
        $events = [];
        foreach($reservations as $reservation) {

            $events[] = [
                'title'     =>'1組 / ' .$reservation->guests . '名',
                'start'     => Carbon::parse($reservation->start_at)->toIso8601String(),
                'end'       => Carbon::parse($reservation->end_at)->toIso8601String(),
                'url'       => route('restaurant.reservations.date',[
                            'date' => Carbon::parse($reservation->start_at)->toDateString()
                ]),
            ];
        }
        return response()->json($events);
    }

     // 予約一覧（日付ごと）
    public function daily($date) {
        $date = Carbon::parse($date);
        $reservations = RestaurantReservation::whereDate('start_at',$date)
            ->orderBy('start_at')
            ->get();
        
        return view('staffpage.reservations.restaurant-index',compact('reservations','date'));
       
    }

      // 予約詳細
    public function show($id) {
        $reservation = RestaurantReservation::with([
            'user.detail'
            
        ])->findOrFail($id);

        return view('staffpage.reservations.restaurant-detail', compact('reservation')
        );

    }
}
