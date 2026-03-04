<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantReservation;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestaurantReservationController extends Controller
{

    public function show($id) {
        $reservation = RestaurantReservation::with([
            'user.detail'
            
        ])->findOrFail($id);

        return view('staffpage.reservations.restaurant-detail', compact('reservation')
        );
       
    }
    /**
     * 特定のレストランを表示（ホテルと同じ ID固定方式）
      */
     public function showInfo()
     {
    //  テストしたいレストランIDをここで指定（3や4など、DBにあるIDに変えてね）
         $id = 5; 
        
         $restaurant = Restaurant::findOrFail($id);

        return view('userpage.booking.restaurant', compact('restaurant'));
   }

    
   public function store(Request $request)
    {
        // ... (バリデーションはそのまま) ...

        // 1. 開始時間を生成
        $start_at = $request->date . ' ' . $request->time . ':00';
        
        // 2. 終了時間を生成（とりあえず開始の2時間後をセットしてエラーを回避）
        $end_at = date('Y-m-d H:i:s', strtotime($start_at . ' +2 hours'));

        // 3. 保存
        RestaurantReservation::create([
            'reservation_id' => 'RES-' . strtoupper(Str::random(8)),
            'user_id'        => Auth::id(),
            'restaurant_id'  => $request->restaurant_id,
            'table_id'       => 1,
            'status_id'      => 1,
            'reserved_at'    => now(),
            'start_at'       => $start_at,
            'end_at'         => $end_at, // ← これを追加！
            'guests'         => $request->guests,
            'total_price'    => 0,
            'other'          => json_encode([
                'name'  => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]),
        ]);

        return view('userpage.booking.restaurant.reservation-success');
    }

    // カレンダー
    public function calendar() {
        return view('staffpage.calendar.restaurant-calendar');       
    }

    public function calendarData() {
        $reservations = RestaurantReservation::all();
        $events = [];
        foreach($reservations as $reservation) {

            $events[] = [
                'title'     =>'1組 / ' .$reservation->guests . '名',
                'start'     => Carbon::parse($reservation->start_at)->toIso8601String(),
                'end'       => Carbon::parse($reservation->end_at)->toIso8601String(),
                // 予約一覧のURLを入れる（まだないので、コメントアウト）
                // 'url'       => route('store.reservation.index',[
                //             'date' => Carbon::parse($reservation->start_at)->format('Y-m-d')
                // ]),
            ];

        }
        return response()->json($events);
       
    }

}
