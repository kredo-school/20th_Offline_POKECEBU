<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;


class HotelController extends Controller
{
    // public function index()
    // {
    //     $hotel = [
    //         'name' => 'Ocean View Hotel',
    //         'location' => 'Cebu City',
    //         'price' => 12000,
    //         'image' => 'https://via.placeholder.com/800x400'
    //     ];

    //     return view('userpage.booking.hotel', compact('hotel'));
    // }

    
    // 上のコードを残す（バックアップ）
    public function sample()
    {
        $hotel = [
            'name' => 'Ocean View Hotel',
            'location' => 'Cebu City',
            'price' => 12000,
            'image' => 'https://via.placeholder.com/800x400'
        ];

        return view('userpage.booking.hotel', compact('hotel'));
    }

    // 実データ一覧表示（新しい index）
    public function index(Request $request)
    {
        $hotels = Hotel::with(['hotelImages', 'rooms.roomType', 'reservations'])
            ->when($request->input('city'), fn($q, $city) => $q->where('city', $city))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('userpage.mypage.hotel-search-result', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = \App\Models\Hotel::with([
            'hotelImages',
            'rooms.roomType',   // rooms -> roomType
            'roomTypes.type',   // optional: if you have roomTypes relation
            'reviews',
            'categories'        // amenities / categories
        ])->findOrFail($id);

        return view('userpage.booking.hotel', compact('hotel'));
    }
    
}
