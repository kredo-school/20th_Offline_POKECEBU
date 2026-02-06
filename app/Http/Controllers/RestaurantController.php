<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantTable;

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

    public function showDetailRestaurant($id)
    {
        $restaurant = Restaurant::with('restaurantImages')->findOrFail($id);

        $tables = RestaurantTable::with(['type', 'status'])
        ->where('restaurant_id', $restaurant->id)
        ->get();


        return view('userpage.booking.detail-restaurant', compact('restaurant', 'tables'));
    }
}


