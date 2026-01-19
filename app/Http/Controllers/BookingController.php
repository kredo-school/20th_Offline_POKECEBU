<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use App\Models\Booking; 

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ユーザーの予約を取得
            $bookings = []; // まだ予約モデルないので空配列

        return view('userpage.mypage.booking', compact('user', 'bookings'));
   

    }
}
