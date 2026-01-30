<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
  public function index()
{
    $hotel = [
        'name' => 'Ocean View Hotel',
        'location' => 'Cebu City',
        'price' => 12000,
        'image' => 'https://via.placeholder.com/800x400'
    ];

    return view('userpage.booking.hotel', compact('hotel'));
}
}
