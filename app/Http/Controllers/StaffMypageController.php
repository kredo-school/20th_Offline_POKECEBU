<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\TmpHotel;
use App\Models\Restaurant;
use App\Models\TmpRestaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\TmpHotelImage;
use App\Models\TmpRestaurantImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffMypageController extends Controller

{
    // ホテルマイページ表示
    public function index()
    {
        // ログインユーザーのホテル情報を取得
        $hotel = Hotel::with('images')->where('id', Auth::id())->first();

        $history = [];
        if ($hotel) {
            // 最新5件の申請履歴を取得
            $history = TmpHotel::where('hotel_id', $hotel->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('staffpage.mypage.mypage-hotel', compact('hotel', 'history'));
    }

    // 編集ページ表示
    public function editStaffMypage()
    {
        $hotel = Hotel::where('id', Auth::id())->first();

        if (!$hotel) {
            return redirect()->route('hotel.staff.mypage.hotel')
                ->withErrors(['error' => 'ホテル情報が見つかりません。']);
        }

        return view('staffpage.mypage.edit-hotel', compact('hotel'));
    }

    // 保存（申請）
    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'image_path' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $hotel = Hotel::where('id', Auth::id())->first();
            if (!$hotel) {
                throw new \Exception('元となるホテルデータが存在しません。');
            }

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

            $data['hotel_id'] = $hotel->id;
            $data['status'] = 'pending';

            $tmpHotel = TmpHotel::create($data);

            if ($request->hasFile('image_path')) {
                $imageFile = $request->file('image_path');
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

                TmpHotelImage::create([
                    'tmp_hotel_id' => $tmpHotel->id,
                    'image' => $base64String,
                ]);
            }

            DB::commit();

            // ✅ 完了画面へリダイレクト
            return redirect()->route('hotel.staff.mypage.hotel.complete');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ホテル保存エラー: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => '保存に失敗しました：' . $e->getMessage()]);
        }
    }

    // 申請完了画面
    public function complete()
    {
        $tmpHotel = TmpHotel::latest()->first();

        if (!$tmpHotel) {
            return redirect()->route('hotel.staff.mypage.hotel');
        }

        return view('staffpage.mypage.hotel-complete', compact('tmpHotel'));
    }



    // レストラン
    public function indexRestaurant()
    {
        $restaurant = Restaurant::first();

        // ログイン中のユーザーが申請した履歴を、新しい順に取得（例えば最新5件）
        $history = TmpRestaurant::where('restaurant_id', $restaurant->id)
            ->latest()
            ->take(5)
            ->get();

        return view('staffpage.mypage.mypage-restaurant', compact('restaurant', 'history'));
    }

    // 編集ページ表示
    public function updateStaffMypagerestaurant(Request $request)
    {
        // 1. バリデーション（緯度経度の数字チェックも追加）
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image_path' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $restaurant = Restaurant::first();
            if (!$restaurant) {
                return redirect()->back()->with('error', 'Restaurant not found.');
            }

            // 2. データの準備
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
            $data['restaurant_id'] = $restaurant->id;
            $data['status'] = 'pending';

            // 基本情報を保存
            $tmpRestaurant = TmpRestaurant::create($data);

            // 3. 画像がある場合
            if ($request->hasFile('image_path')) {
                $imageFile = $request->file('image_path');
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

                TmpRestaurantImage::create([
                    'tmp_restaurant_id' => $tmpRestaurant->id,
                    'image' => $base64String,
                ]);
            }

            DB::commit();
            return redirect()->route('restaurant.restaurant.complete');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Restaurant Save Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to save: ' . $e->getMessage()]);
        }
    }

    public function restaurantcomplete()
    {
        // 完了画面に表示するための最新の申請データを取得
        // hotel版と同様、カラム名に合わせて調整してください
        $tmpRestaurant = TmpRestaurant::latest()->first();

        return view('staffpage.mypage.restaurant-complete', compact('tmpRestaurant'));
    }
    // --- 追加分: レストラン編集画面を表示する ---
    public function editStaffMypagerestaurant()
    {
        // 1. レストラン情報を取得（1件目を取得）
        $restaurant = Restaurant::first();

        // 2. もしデータがなければエラーを回避するために空のモデルを渡すか、チェックを行う
        if (!$restaurant) {
            // 必要に応じてエラー処理
        }

        // 3. 編集画面を表示
        return view('staffpage.mypage.edit-restaurant', compact('restaurant'));
    }
}
