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

    public function editProfile()
    {
        $user = Auth::user();
        return view('userpage.mypage.edit-profile', compact('user'));
    }

    public function editPersonal()
    {
        $user = Auth::user();
        return view('userpage.mypage.edit-personal', compact('user'));
    }

    public function editAddress()
    {
        $user = Auth::user();
        return view('userpage.mypage.edit-adress', compact('user'));
    }

    public function favorite()
    {
        return view('userpage.mypage.favorite');
    }
}
