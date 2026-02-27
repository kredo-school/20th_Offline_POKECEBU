<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\TmpHotel;
use App\Models\Restaurant;
use App\Models\TmpRestaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\TmpHotelImage;
use App\Models\TmpRestaurantImage;

class StaffMypageController extends Controller
{
    // ホテルマイページ表示
    public function index()
    {
        // ホテル情報を取得し、リレーション先の images も一緒に読み込む
        $hotel = Hotel::with('images')->first();

        // もし images テーブルから最新の1枚だけ取り出すなら
        $hotelImage = $hotel->images()->latest()->first();

        return view('staffpage.mypage.mypage-hotel', compact('hotel', 'hotelImage'));
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



    public function updateStaffMypagerestaurant(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            // ... 他のバリデーション ...
            'image_path' => 'nullable|image|max:2048',
        ]);

        // 2. レストランの基本情報をTmpRestaurantに保存
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

        $restaurant = Restaurant::first();
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurant not found.');
        }

        $data['restaurant_id'] = $restaurant->id;
        $data['status'] = 'pending';

        // 基本情報を保存
        $tmpRestaurant = TmpRestaurant::create($data);

        // 3. 画像がある場合、TmpRestaurantImageテーブルにBase64で保存
        if ($request->hasFile('image_path')) {
            $imageFile = $request->file('image_path');

            // Base64エンコード処理
            $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
            $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

            // 画像専用テーブルに保存
            TmpRestaurantImage::create([
                'tmp_restaurant_id' => $tmpRestaurant->id, // 外部キー（接着剤）
                'image' => $base64String,
            ]);
        }

        // 完了画面へリダイレクト
        return redirect()->route('restaurant.complete');
    }
    public function restaurantcomplete()
    {
        return view('staffpage.mypage.restaurant-complete');
    }
}
