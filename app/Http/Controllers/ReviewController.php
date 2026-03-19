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
    // ホテルのレビュー一覧を表示
public function showHotelReviews($id)
{
    $hotel = Hotel::findOrFail($id);
    $reviews = Review::whereHas('hotelReservation', function($q) use ($id) {
        $q->where('hotel_id', $id);
    })->with('user')->latest()->paginate(10); // ページネーションを追加

    return view('userpage.booking.reviews.hotel', [
        'target' => $hotel,
        'reviews' => $reviews,
        'type' => 'hotel'
    ]);
}

// レストランのレビュー一覧を表示
public function showRestaurantReviews($id)
{
    $restaurant = Restaurant::findOrFail($id);
    $reviews = Review::whereHas('restaurantReservation', function($q) use ($id) {
        $q->where('restaurant_id', $id);
    })->with('user')->latest()->paginate(10);

    return view('userpage.booking.reviews.restaurant', [
        'target' => $restaurant,
        'reviews' => $reviews,
        'type' => 'restaurant'
    ]);
}

    // レビュー保存
    public function store(Request $request) {
       $request->validate([
            'rating'        => 'required|numeric|min:0|max:5',
            
       ]);

        //予約済かチェック
        if ($request->hotel_reservation_id) {
            $reservation = HotelReservation::where('id',$request->hotel_reservation_id)
                ->where('user_id',Auth::id())
                ->whereDate('end_at','<',now())
                ->firstOrFail();

            if (Review::where('hotel_reservation_id', $reservation->id)->exists()) {
                return back()->with('error', 'You have already reviewed this stay.');
            }

            Review::create([
              'user_id'              => Auth::id(),
              'hotel_reservation_id' => $request->hotel_reservation_id,
              'rating'               => $request->rating,
              'comment'              => $request->comment
            ]);

            $this->updateHotelAverage($reservation->hotel_id);

        } elseif ($request->restaurant_reservation_id) {
            $reservation = RestaurantReservation::where('id', $request->restaurant_reservation_id)
                ->where('user_id', Auth::id())
                ->whereDate('start_at', '<', now())
                ->firstOrFail();
                
            if (Review::where('restaurant_reservation_id', $reservation->id)->exists())  {
                return back()->with('error', 'You have already reviewed this visit.');
            }

            Review::create([
                'user_id'                   => Auth::id(),
                'restaurant_reservation_id' => $request->restaurant_reservation_id,
                'rating'                    => $request->rating,
                'comment'                   => $request->comment

            ]);
            $this->updateRestaurantAverage($reservation->restaurant_id);
        }
       
       return back()->with('success', 'Your review has been submitted.');
    }

    // レビュー削除
    public function destroy($id) {
       $review = Review::findOrFail($id);

       if($review->user_id !== Auth::id()) {
        abort(403);
       }

      if ($review->hotel_reservation_id) {
        $reservation = HotelReservation::find($review->hotel_reservation_id);
        $hotelId = $reservation->hotel_id;
      } else {
        $reservation = RestaurantReservation::find($review->restaurant_reservation_id);
        $restaurantId =$reservation->restaurant_id;
      }

       $review->delete();
       if (isset($hotelId)) {
        $this->updateHotelAverage($hotelId);
       } else {
        $this->updateRestaurantAverage($restaurantId);
       }

       return back()->with('success', 'Your review has been deleted.');
    }

    // 平均評価の更新
   private function updateHotelAverage($hotelId) {
    $average = Review::whereHas('hotelReservation', function($q) use ($hotelId) {
        $q->where('hotel_id', $hotelId);
    })->avg('rating');

    Hotel::where('id', $hotelId)->update([
        'star_rating' => $average
    ]);
}

private function updateRestaurantAverage($restaurantId) {
    $average = Review::whereHas('restaurantReservation', function($q) use ($restaurantId) {
        $q->where('restaurant_id', $restaurantId);
    })->avg('rating');

    Restaurant::where('id', $restaurantId)->update([
        'star_rating' => $average
    ]);
}
}