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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffMypageController extends Controller
{
    // ホテルマイページ表示
    public function index()
    {
        // 1. ホテル情報を取得（画像リレーションも一緒に読み込む）
        $hotel = Hotel::with('images')->first();

        // 2. 履歴を取得（最新5件）
        $history = [];
        $hotelImage = null; // 初期化しておく

        if ($hotel) {
            $history = TmpHotel::where('hotel_id', $hotel->id)
                ->latest()
                ->take(5)
                ->get();

            // 3. 表示用の画像を取得（最新の1枚）
            $hotelImage = $hotel->images()->latest()->first();
        }

        // 4. 全ての変数を compact に入れる（ここが重要！）
        return view('staffpage.mypage.mypage-hotel', compact('hotel', 'history', 'hotelImage'));
    }
    // 編集ページ
    public function editStaffMypage()
    {
        // 1. ログインしているユーザー（あなた）の情報を取得
        $user = \Illuminate\Support\Facades\Auth::user();

        // 2. ホテルの情報も取得
        $hotel = Hotel::first();

        // 3. 両方の荷物を Blade に手渡す！ (ここがポイント)
        return view('staffpage.mypage.edit-hotel', compact('hotel', 'user'));
    }

    public function storeHotel(Request $request)
    {
        // 1. バリデーション
        // 失敗すると自動的に元の画面に戻り、$errorsに中身が入ります
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'image_path' => 'nullable|image|max:2048', // 2MBまで
        ]);

        // 2. トランザクション開始（データの整合性を守るため）
        DB::beginTransaction();

        try {
            // 3. 保存データの作成
            // モデルの$fillableにない項目（updated_userなど）はあえて外しています
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

            // 元となるホテルのIDを取得（ログインユーザーに紐づくものなど、状況に合わせて調整してください）
            $hotel = Hotel::first();
            if (!$hotel) {
                throw new \Exception('元となるホテルデータが存在しません。');
            }

            $data['hotel_id'] = $hotel->id;
            $data['status'] = 'pending';

            // 4. TmpHotelテーブルに保存
            $tmpHotel = TmpHotel::create($data);

            // 5. 画像がある場合、TmpHotelImageテーブルにBase64で保存
            if ($request->hasFile('image_path')) {
                $imageFile = $request->file('image_path');
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                $base64String = 'data:' . $imageFile->getMimeType() . ';base64,' . $imageData;

                TmpHotelImage::create([
                    'tmp_hotel_id' => $tmpHotel->id,
                    'image' => $base64String,
                ]);
            }

            // 6. 全ての保存が成功したらDBを確定させる
            DB::commit();

            // 7. 完了画面へリダイレクト
            // ※ route名が 'staff.mypage.hotel.complete' の可能性もあるので注意
            return redirect()->route('hotel.mypage.hotel.complete');
        } catch (\Exception $e) {
            // 失敗したらここに来る。保存をキャンセルしてエラーを表示
            DB::rollBack();

            // ログに詳細を出す（storage/logs/laravel.log で確認可能）
            Log::error('ホテル保存エラー: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => '保存に失敗しました：' . $e->getMessage()]);
        }
    }




    // 申請完了画面// 申請完了画面
    public function complete()
    {


        $tmpHotel = TmpHotel::latest()->first();



        if (!$tmpHotel) {
            return redirect()->route('staff.mypage.hotel');
        }

        return view('staffpage.mypage.hotel-complete', compact('tmpHotel'));
    }
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
            return redirect()->route('restaurant.complete');
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
