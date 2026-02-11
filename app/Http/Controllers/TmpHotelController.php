<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TmpHotelController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('userpage.mypage.signup-for-company');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'target_type' => 'required|in:hotel,restaurant',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'star_rating' => 'nullable|numeric|min:0|max:5',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'representative_name' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        // どの tmp テーブルに入れるか
        $isHotel = ($data['target_type'] ?? 'hotel') === 'hotel';
        $table = $isHotel ? 'tmp_hotels' : 'tmp_restaurants';

        DB::beginTransaction();

        try {
            $payload = [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'star_rating' => $data['star_rating'] ?? null,
                'phone' => $data['phone'] ?? null,
                'website' => $data['website'] ?? null,
                'status' => 'pending',
                // 'updated_user' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
                // 代表者情報を tmp に保存する
                'representative_name' => $data['representative_name'] ?? null,
                'representative_email' => $data['representative_email'] ?? null,
            ];

            // 申請レコードを作成して ID を取得
            $tmpId = DB::table($table)->insertGetId($payload);

            // 画像があれば保存して tmp_hotel_images に登録
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // 一意なファイル名を作る
                    $filename = time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
                    // 保存先（tmp 用フォルダ）
                    $tmpDir = $isHotel ? "tmp/hotels/{$tmpId}" : "tmp/restaurants/{$tmpId}";

                    // public ディスクに保存（戻り値は "tmp/hotels/{id}/{filename}"）
                    $storedPath = $file->storeAs($tmpDir, $filename, 'public');

                    // tmp_hotel_images テーブルに登録（テーブル名は tmp_hotel_images / tmp_restaurant_images など）
                    $imageTable = $isHotel ? 'tmp_hotel_images' : 'tmp_restaurant_images';
                    DB::table($imageTable)->insert([
                        $isHotel ? 'tmp_hotel_id' : 'tmp_restaurant_id' => $tmpId,
                        'image' => $storedPath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            DB::commit();

            return redirect()->back()->with('status', '申請を受け付けました。管理者の承認をお待ちください。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store tmp application', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('申請の保存中にエラーが発生しました。');
        }
    }
}
