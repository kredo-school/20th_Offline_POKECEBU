<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Http\Controllers\Controller;

class HotelStaffController extends Controller
{
    public function index()
    {
        return view('staffpage.home-hotel');
    }

    public function reservations()
    {
        $reservations = Reservation::with('guest', 'room')->get();
        return view('staff.reservations.index', compact('reservations'));
    }


    public function showhotel()
    {
        return view('staffpage.edit-hotel');
    }

    public function showrestaurant()
    {
        return view('staffpage.edit-restaurant');
    }
}
