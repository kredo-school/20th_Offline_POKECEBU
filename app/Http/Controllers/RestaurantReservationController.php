<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestaurantReservation;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestaurantReservationController extends Controller
{

    public function show($id) {
        // 仮データ（後でDBから取得できる形にする）
        return view('staff.reservation.info',[
            'reservationId' => $id
        ]);
       
    }
    /**
     * 特定のレストランを表示（ホテルと同じ ID固定方式）
      */
     public function showInfo()
     {
    //  テストしたいレストランIDをここで指定（3や4など、DBにあるIDに変えてね）
         $id = 3; 
        
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
// ここを修正！ 'restaurant.show' という名前のルートへ飛ばす
   return redirect()
    ->route('mypage')
    ->with('success', 'Reservation completed successfully!');

}
}
