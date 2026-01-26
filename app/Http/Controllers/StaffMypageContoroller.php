<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffMypageContoroller extends Controller
{
    public function index()
    {
        return view('staffpage.mypage.mypage-hotel');
    }
    public function editStaffMypage(){
        return view ('staffpage.mypage.edit-hotel');
    }

    public function indexRestaurant(){
        return view('staffpage.mypage.mypage-restaurant');
    }
    public function editStaffMypagerestaurant(){
        return view ('staffpage.mypage.edit-restaurant');
    }
}
