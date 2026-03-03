<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // ユーザーマイページに表示
    public function index(){
        $favorites = Favorite::where('user_id', Auth::id())->get();
        $hotelIds = $favorites
        ->where('target_type', 'hotel')
        ->pluck('target_id');

        $restaurantIds = $favorites
            ->where('target_type', 'restaurant')
            ->pluck('target_id');

        $favoriteHotels = Hotel::whereIn('id', $hotelIds)->get();
        $favoriteRestaurants = Restaurant::whereIn('id', $restaurantIds)->get();

        $allFavorites = $favoriteHotels
            ->merge($favoriteRestaurants)
            ->sortByDesc('create_at')
            ->values();

        return view('userpage.mypage.favorite', compact('allFavorites', 'favoriteHotels', 'favoriteRestaurants'));
    }

    // お気に入り登録
    public function store($type,$id) {
       Favorite::firstOrCreate([
            'user_id'       => Auth::id(),
            'target_type'   => $type,
            'target_id'     => $id
       ]);
       return response()->json([
         'status' => 'added'
       ]);
    }

    // お気に入り解除
    public function destroy($type, $id) {
       Favorite::where([
            'user_id'       => Auth::id(),
            'target_type'   => $type,
            'target_id'     => $id
       ])->delete();
       return response()->json([
        'status' => 'removed'
       ]);
    }
}
