<?php

namespace App\Http\Controllers;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurant = [
            'name' => 'Ocean Breeze Restaurant',
            'location' => 'Cebu City',
            'price' => 3500,
            'image' => 'https://via.placeholder.com/800x400'
        ];

        return view('userpage.booking.restaurant', compact('restaurant'));
    }
}


