<?php
namespace App\Http\Controllers;
use App\Models\RestaurantReservation;
use App\Http\Controllers\Controller;

class RestaurantStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-restaurant');
    }
}
