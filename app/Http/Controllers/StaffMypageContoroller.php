<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Restaurant;     
use Illuminate\Support\Facades\Auth;

class StaffMypageContoroller extends Controller
{
public function index()
{
    // ログインしてるスタッフのホテルを取得
    $hotel = Hotel::where('updated_user', Auth::id())->first();

    return view('staffpage.mypage.mypage-hotel', compact('hotel'));
}


    // ホテル作成・編集画面
    public function editStaffMypage()
    {
        $hotel = Hotel::where('updated_user', Auth::id())->first();

        return view('staffpage.mypage.edit-hotel', compact('hotel'));
    }

    // ホテル保存（新規 or 更新）
    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
            'email' => 'nullable|email',
            'representative_name' => 'nullable|string',
        ]);

        Hotel::updateOrCreate(
            ['updated_user' => Auth::id()],
            [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'website' => $request->website,
                'email' => $request->email,
                'representative_name' => $request->representative_name,
            ]
        );

        return redirect()->route('staff.mypage.hotel')
            ->with('success', 'ホテル情報を保存しました');
    }

    // レストラン
   // レストランのマイページ表示
    public function indexRestaurant()
    {
        // ここでは仮にユーザーに紐づくレストランを1件取得
        // updated_user がログインユーザーのIDと一致するレコードを取得
        $restaurant = Restaurant::where('updated_user', Auth::id())->first();

        return view('staffpage.mypage.mypage-restaurant', compact('restaurant'));
    }

    // レストラン情報編集ページ
    public function editStaffMypagerestaurant()
    {
        $restaurant = Restaurant::where('updated_user', Auth::id())->first();

        return view('staffpage.mypage.edit-restaurant', compact('restaurant'));
    }

    // レストラン情報更新処理
    public function updateStaffMypagerestaurant(Request $request)
    {
        $restaurant = Restaurant::where('updated_user', Auth::id())->first();

        if (!$restaurant) {
            // レコードがなければ新規作成
            $restaurant = new Restaurant();
            $restaurant->updated_user = Auth::id();
        }

        // バリデーション
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'star_rating' => 'nullable|numeric',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'image_path' => 'nullable|file|image|max:2048',
            'owner_name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('restaurant_images', 'public');
            $data['image_path'] = $path;
        }

        $restaurant->fill($data);
        $restaurant->save();

        return redirect()->route('staff.mypage.restaurant')->with('success', 'Restaurant info updated!');
    }
}
