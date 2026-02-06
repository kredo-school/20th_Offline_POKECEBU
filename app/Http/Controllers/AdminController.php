<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\TmpHotel;
use App\Models\TmpHotelImage;
use App\Models\Hotel;
use App\Models\HotelImage;


class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::where('role_id', 3)->count();

        return view('adminpage.home', compact('totalUsers'));
    }

    public function customers()
    {
        return view('adminpage.customer.customers'); // Customer表用
    }

    public function hotels()
    {
        return view('adminpage.hotel.hotels'); // Hotel表用
    }
    
    public function addHotel()
    {
        return view('adminpage.hotel.add');
    }
      public function editHotel()
    {
        return view('adminpage.hotel.edit');
    }

    public function restaurants()
    {
        return view('adminpage.restaurant.restaurants'); // Restaurant表用
    }
    public function editRestaurant()
    {
        return view('adminpage.restaurant.edit');
    }
    public function addRestaurant(){
        return view('adminpage.restaurant.add');
    }

    public function admins()
    {
        // 管理者一覧ページのビュー
        return view('adminpage.admin.admin'); 
    }


    public function analysisHotel()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.hotel.analysis-hotel');
    }

    public function analysisRestaurant()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.restaurant.analysis-restaurant');
    }

    public function addAdmin()
    {   
        return view('adminpage.admin.add');
    }

    public function editAdmin()
    {
        return view('adminpage.admin.edit');
    }

    // AdminController.php
    public function editCustomer()
    {
        return view('adminpage.customer.edit-customers');
    }
    public function addCustomer()
    {
        return view('adminpage.customer.add-customers');
    }

    // 2/4 emi 事業者情報登録　承認画面

    public function approveHotel($id)
    {
        DB::beginTransaction();

        try {
            $tmp = TmpHotel::with('images')->findOrFail($id);

            $hotel = Hotel::create([
                'name' => $tmp->name,
                'description' => $tmp->description,
                'address' => $tmp->address,
                'city' => $tmp->city,
                'latitude' => $tmp->latitude,
                'longitude' => $tmp->longitude,
                'star_rating' => $tmp->star_rating,
                'phone' => $tmp->phone,
                'website' => $tmp->website,
                'updated_user' => $tmp->updated_user,
            ]);

            foreach ($tmp->images as $tmpImage) {
                $oldPath = $tmpImage->image;

                // 必要ならパスを変える／一意化する処理を入れてください
                if (Storage::disk('public')->exists($oldPath)) {
                    // コピーではなく move したい場合は ->move()
                    Storage::disk('public')->copy($oldPath, $oldPath);
                }

                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'image' => $oldPath,
                ]);
            }

            // tmp 側を削除（画像は tmp_hotel_images テーブルから削除）
            $tmp->images()->delete();
            $tmp->delete();

            DB::commit();

            return redirect()->back()->with('status', 'ホテル申請を承認しました！');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Hotel approval failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('承認処理中にエラーが発生しました。');
        }
    }

    /**
     * 承認一覧ページ（左に一覧、右に最初の申請を表示）
     */
    public function hotelApproval()
    {
        $tmpHotels = TmpHotel::with('images')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 既定で最初の申請を選択（なければ null）
        $tmpHotel = $tmpHotels->first();

        return view('adminpage.hotel.pending-approval', compact('tmpHotels', 'tmpHotel'));
    }

    /**
     * 個別申請を選択して表示（Review ボタンでここに飛ばす）
     */
    public function showPending($id)
    {
        $tmpHotels = TmpHotel::with('images')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $tmpHotel = TmpHotel::with('images')->findOrFail($id);

        return view('adminpage.hotel.pending-approval', compact('tmpHotels', 'tmpHotel'));
    }
}
