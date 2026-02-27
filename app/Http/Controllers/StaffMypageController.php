<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\TmpHotel;
use App\Models\Restaurant;
use App\Models\TmpRestaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\TmpHotelImage;

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

  
public function storeHotel(Request $request)
{
    // 1. バリデーション
    $request->validate([
        'name' => 'required|string|max:255',
        // 他の項目...
        'image_path' => 'nullable|image|max:2048', // ここで画像ファイルをチェック
    ]);

    // 2. ホテルの基本情報をTmpHotelに保存
    $data = $request->only([
        'name', 'description', 'address', 'city', 'latitude', 'longitude', 
        'star_rating', 'phone', 'website', 'representative_name', 
        'representative_email', 'email'
    ]);
    $data['hotel_id'] = Hotel::first()->id; 
    $data['status'] = 'pending';

    $tmpHotel = TmpHotel::create($data); // 保存してIDを取得

    // 3. 画像がある場合、TmpHotelImageテーブルにBase64で保存
    if ($request->hasFile('image_path')) {
        $imageFile = $request->file('image_path');
        
        // Base64エンコード処理
        $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
        $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

        // TmpHotelImageモデルを使って保存
        TmpHotelImage::create([
            'tmp_hotel_id' => $tmpHotel->id, // 作成したTmpHotelのIDを紐付け
            'image' => $base64String,        // Base64文字列
        ]);
    }

      return redirect()->route('hotel.mypage.hotel.complete');
}
 




    // 申請完了画面// 申請完了画面
    public function complete()
    {
        // resources/views/staffpage/mypage/hotel-complete.blade.php を表示する
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
