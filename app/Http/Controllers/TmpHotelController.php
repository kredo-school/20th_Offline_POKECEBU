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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
            // 代表者情報を保存したいなら下を有効にして payload に追加する
            'representative_name' => 'nullable|string|max:255',
            'representative_email' => 'nullable|email|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);


        // どのテーブルに入れるか
        $table = ($data['target_type'] ?? 'hotel') === 'hotel' ? 'tmp_hotels' : 'tmp_restaurants';

        // トランザクションでまとめる
        try {
            DB::beginTransaction();

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
                'updated_user' => Auth::id(), // null を許容する場合はそのまま
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // もし代表者情報を tmp テーブルに保存したいならここに追加
            // $payload['representative_name'] = $data['representative_name'] ?? null;
            // $payload['representative_email'] = $data['representative_email'] ?? null;

            // 申請レコードを作成して ID を取得
            $tmpId = DB::table($table)->insertGetId($payload);

            // 画像があれば保存して tmp_hotel_images に登録
            if ($request->hasFile('images')) {
                $files = $request->file('images');

                // 1枚だけ選ばれた場合、$files が UploadedFile の単体になることがあるので、配列化
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    if (!$file || !$file->isValid()) continue;

                    $path = $file->store('company_images', 'public');

                    DB::table('tmp_hotel_images')->insert([
                        'tmp_hotel_id' => $tmpId,
                        'image' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            DB::commit();

            return redirect()->back()->with('status', "Your application has been received. Please wait for the administrator's approval.申請を受け付けました。管理者の承認をお待ちください。");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to store tmp hotel application', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload ?? null,
            ]);

            return redirect()->back()->withErrors('An error occurred while saving your application. Please try again later.');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
