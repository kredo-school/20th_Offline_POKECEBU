<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HotelStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-hotel');
    }

    public function showhotel(){
        return view('staffpage.edit-hotel');
    }

    public function showrestaurant(){
        return view('staffpage.edit-restaurant');
    }
}
