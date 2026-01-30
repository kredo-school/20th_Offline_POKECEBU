<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
class HotelController extends Controller
{

    private $hotel;

    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

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

public function showDetailHotel($id)
    {
        $hotel = $this->hotel->findOrFail($id);

        return view('userpage.booking.detail-hotel', compact('hotel'));
    }
};
