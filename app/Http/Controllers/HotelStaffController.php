<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HotelStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-hotel');
    }
}
