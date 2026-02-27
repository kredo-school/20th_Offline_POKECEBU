<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HotelReservation;
use App\Models\RestaurantReservation;
use App\Models\Review;
use App\Models\Hotel;
use App\Models\Restaurant;

class ReviewController extends Controller
{
    // レビュー保存
    public function store(Request $request) {
       $request->validate([
            'rating'        => 'required|numeric|min:0|max:5',
            'target_type'   => 'required',
            'target_id'     => 'required'
       ]);

        //予約済かチェック
        if ($request->target_type == 'hotel') {
            $allowed = HotelReservation::where('user_id',Auth::id())
                ->where('hotel_id',$request->target_id)
                ->whereDate('end_at','<',now())
                ->exists();
        } else {
            $allowed = RestaurantReservation::where('user_id',Auth::id())
                ->where('restaurant_id',$request->target_id)
                ->whereDate('start_at','<',now())
                ->exists();
        }

        if(!$allowed) abort(403);

       Review::create([
         'user_id'          => Auth::id(),
         'target_type'      => $request->target_type,
         'target_id'        => $request->target_id,
         'rating'           => $request->rating,
         'comment'          => $request->comment
       ]);

       $this->updateAverage($request->target_type, $request->target_id);
       return back();
    }

    // 平均評価の更新
    private function updateAverage($type, $id) {
        $average = Review::where('target_type', $type)
            ->where('target_id',$id)
            ->avg('rating');
        
        if ($type == 'hotel') {
            Hotel::where('id',$id)->update([
                'star_rating' => $average
            ]);
        } else {
            Restaurant::where('id',$id)->update([
                'star_rating' => $average
            ]);
        }
    }
}