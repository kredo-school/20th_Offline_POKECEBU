<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;



class HotelController extends Controller
{

    private $hotel;

    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }


    public function showDetailHotel($id)
    {
        $hotel = Hotel::with('hotelImages')->findOrFail($id);
        $rooms = HotelRoom::with(['type', 'status', 'images'])
        ->where('hotel_id', $id)
        ->get();

        return view('userpage.booking.hotel.detail-hotel', compact('hotel', 'rooms'));
    }

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
     public function roomInfo()
{
    // 仮のホテルIDを固定
    $id = 3; // たぬきホテルなど、DBに存在するID
$hotel = Hotel::with('roomTypes.roomType')->findOrFail($id);


    return view('userpage.booking.hotel.hotel', compact('hotel'));
}
};
   




