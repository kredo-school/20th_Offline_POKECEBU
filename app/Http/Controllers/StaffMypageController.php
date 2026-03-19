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
        $hotel = Hotel::with('images')->where('id', Auth::user()->id)->first();

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
        // ★変更: with('images') を追加
        $hotel = Hotel::with('images')->where('id', Auth::user()->id)->first();

        if (!$hotel) {
            return redirect()->route('hotel.staff.mypage.hotel')
                ->withErrors(['error' => 'No hotel information.']);
        }

        return view('staffpage.mypage.edit-hotel', compact('hotel'));
    }

    // 保存（申請）
    public function storeHotel(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            // ★変更: image_path → images[] で複数対応
            'images'   => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        DB::beginTransaction();
        try {
           // これに変える
            $hotel = Hotel::where('id', Auth::user()->id)->first();
            if (!$hotel) {
                throw new \Exception('The original hotel data does not exist.');
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

            // ★変更: 複数画像をループしてbase64で保存
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imageData    = base64_encode(file_get_contents($imageFile->getRealPath()));
                    $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

                    TmpHotelImage::create([
                        'tmp_hotel_id' => $tmpHotel->id,
                        'image'        => $base64String,
                    ]);
                }
            }

            DB::commit();

            // 完了画面へリダイレクト
            return redirect()->route('hotel.staff.mypage.hotel.complete');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to save:' . $e->getMessage()]);
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
        // ★変更: emailでログインユーザーのレストランを取得
        $restaurant = Restaurant::where('id', Auth::user()->id)->first();

        $history = [];
        if ($restaurant) {
            $history = TmpRestaurant::where('restaurant_id', $restaurant->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('staffpage.mypage.mypage-restaurant', compact('restaurant', 'history'));
    }

    // 編集ページ表示
    public function updateStaffMypagerestaurant(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            // ★変更: 複数画像対応
            'images'    => 'nullable|array',
            'images.*'  => 'image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // ★変更: emailでログインユーザーのレストランを取得
            $restaurant = Restaurant::where('id', Auth::user()->id)->first();
            if (!$restaurant) {
                return redirect()->back()->with('error', 'Restaurant not found.');
            }

            $data = $request->only([
                'name', 'description', 'address', 'city', 'latitude', 'longitude',
                'star_rating', 'phone', 'website', 'representative_name',
                'representative_email', 'email'
            ]);
            $data['restaurant_id'] = $restaurant->id;
            $data['status'] = 'pending';

            $tmpRestaurant = TmpRestaurant::create($data);

            // ★変更: 複数画像をループしてbase64で保存（保存先・形式は変更なし）
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imageData    = base64_encode(file_get_contents($imageFile->getRealPath()));
                    $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

                    TmpRestaurantImage::create([
                        'tmp_restaurant_id' => $tmpRestaurant->id,
                        'image'             => $base64String,
                    ]);
                }
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
        $tmpRestaurant = TmpRestaurant::latest()->first();
        return view('staffpage.mypage.restaurant-complete', compact('tmpRestaurant'));
    }

    // レストラン編集画面表示
    public function editStaffMypagerestaurant()
    {
        // ★変更: emailでログインユーザーのレストランを取得
        $restaurant = Restaurant::where('id', Auth::user()->id)->first();

        if (!$restaurant) {
            return redirect()->route('restaurant.staff.mypage.restaurant')
                ->withErrors(['error' => 'No restaurant information.']);
        }

        return view('staffpage.mypage.edit-restaurant', compact('restaurant'));
    }
}
