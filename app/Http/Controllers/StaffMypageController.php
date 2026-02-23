<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\TmpHotel;
use App\Models\Restaurant;
use App\Models\TmpRestaurant;
use Illuminate\Support\Facades\Auth;

class StaffMypageController extends Controller
{
    // ホテルマイページ表示
    public function index()
    {
        $hotel = Hotel::first(); // 1ホテル担当前提
        return view('staffpage.mypage.mypage-hotel', compact('hotel'));
    }

    // 編集ページ
public function editStaffMypage()
{
    $hotel = Hotel::first(); 
    return view('staffpage.mypage.edit-hotel', compact('hotel'));
}

    // 申請保存（TmpHotelに保存）
    public function storeHotel(Request $request)
{
    // バリデーション
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'star_rating' => 'nullable|numeric|min:0|max:5',
        'phone' => 'nullable|string',
        'website' => 'nullable|string',
        'representative_name' => 'nullable|string|max:255',
        'representative_email' => 'nullable|email|max:255',
        'email' => 'nullable|email|max:255',
        'image_path' => 'nullable|file|image|max:2048',
    ]);

    // 保存するカラムをすべて取り出す
    $data = $request->only([
        'name', 'description', 'address', 'city', 'latitude', 'longitude', 
        'star_rating', 'phone', 'website', 'representative_name', 
        'representative_email', 'email'
    ]);

    // 画像保存
    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('hotel_images','public');
        $data['image_path'] = $path;
    }

    $data['hotel_id'] = Hotel::first()->id; // 元のホテルID
    $data['status'] = 'pending'; // 申請中

    TmpHotel::create($data);

    // 完了画面へ
    return redirect()->route('hotel.mypage.hotel.complete');
}
    
    


    // 申請完了画面
    public function complete()
    {
        return view('staffpage.mypage.hotel-complete');
    }
    

       public function indexRestaurant()
    {
        $restaurant = Restaurant::first();
        return view('staffpage.mypage.mypage-restaurant', compact('restaurant'));
    }

    // 編集ページ表示
    public function editStaffMypagerestaurant()
    {
        $restaurant = Restaurant::first();
        return view('staffpage.mypage.edit-restaurant', compact('restaurant'));
    }

    // 更新申請（TmpRestaurantへ保存）
    public function updateStaffMypagerestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'star_rating' => 'nullable|numeric|min:0|max:5',
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
            'representative_name' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
            'email' => 'nullable|email|max:255',
            'image_path' => 'nullable|file|image|max:2048',
        ]);

        $data = $request->only([
            'name',
            'description',
            'address',
            'city',
            'latitude',
            'longitude',
            'star_rating',
            'phone',
            'website',
            'representative_name',
            'representative_email',
            'email'
        ]);

        // 画像保存
        if ($request->hasFile('image_path')) {
            $data['image_path'] =
                $request->file('image_path')->store('restaurant_images', 'public');
        }

        $restaurant = Restaurant::first();

        if (!$restaurant) {
            return redirect()->route('restaurant.mypage')
                ->with('error', 'Restaurant not found.');
        }

        $data['restaurant_id'] = $restaurant->id;
        $data['status'] = 'pending';

        TmpRestaurant::create($data);

        return redirect()->route('restaurant.complete')
            ->with('success', 'Update request submitted successfully.');
    }
      public function restaurantcomplete()
    {
        return view('staffpage.mypage.restaurant-complete');
    }
}