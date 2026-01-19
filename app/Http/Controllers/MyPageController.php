<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = [];

        return view('userpage.mypage.mypage', compact('user', 'bookings'));
    }
}
