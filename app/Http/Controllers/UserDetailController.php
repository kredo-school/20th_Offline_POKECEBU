<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;
use App\Models\HotelReservation;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{
    // UserDetailController.php

    public function show(Request $request)
    {
        $user = Auth::user();
        $userDetail = UserDetail::where('user_id', $user->id)->first();
        $otherGuests = session('other_guests', []);

        // 重要：もしURLから hotel_id が送られてきたらセッションに保存する
        if ($request->has('hotel_id')) {
            session([
                'hotel_id'     => $request->hotel_id,
                'room_type_id' => $request->room_type_id,
                'guests_count' => $request->guests,
                'checkin'      => $request->checkin,   // ← 追加
                'checkout'     => $request->checkout,  // ← 追加
            ]);
        }

        $isBooking = session()->has('hotel_id');

        return view('userpage.booking.hotel.mypage', compact('userDetail', 'otherGuests', 'isBooking'));
    }


    // 更新・保存
    // App\Http\Controllers\UserDetailController.php

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. メインゲスト（ログインユーザー）のプロフィール情報を保存・更新
        $userDetail = UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'first_name',
                'last_name',
                'birthday',
                'phone',
                'street_address',
                'city',
                'state',
                'postal_code'
            ])
        );

        // 2. 追加ゲスト（Other Guests）の情報をセッションに保存
        // フォームの name="other_guests[0][name]" などの配列データをそのまま保存します
        if ($request->has('other_guests')) {
            session(['other_guests' => $request->input('other_guests')]);
        }

        // 3. もし予約確定済みで、後からマイページを編集した場合の処理（念のため）
        if ($request->has('reservation_id')) {
            $reservation = HotelReservation::find($request->reservation_id);
            if ($reservation) {
                $reservation->other = json_encode(session('other_guests', []));
                $reservation->save();
            }
        }
        if (session()->has('hotel_id')) {
            return redirect()->route('user.reservation.confirmation')
                ->with('success', 'Information saved!');
        }

        // 予約中でない場合は通常のマイページへ
        return redirect()->route('user.mypage')->with('success', 'Profile updated!');
    }
}
