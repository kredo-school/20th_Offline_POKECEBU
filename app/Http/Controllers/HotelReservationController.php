<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelRoomType;
use App\Models\HotelReservation;



class HotelReservationController extends Controller
{


    // HotelReservationController.php

    public function show($hotelId, Request $request)
    {
        // セッションクリアの処理
        if ($request->has('clear_reservation_session')) {
            session()->forget(['hotel_id', 'room_type_id', 'guests_count', 'other_guests']);
        }

        // ホテル情報と、紐づくルームタイプ・画像を取得
        $hotel = Hotel::with([
            'roomTypes.roomType', // room_types テーブルとそのマスタ
            'images'
        ])->findOrFail($hotelId);

        // あなたが提示した「ルームタイプ一覧」のBladeを指定
        return view('userpage.booking.hotel.hotel', compact('hotel'));
    }
    public function confirmation(Request $request)
    {
        $hotelId = $request->hotel_id ?? session('hotel_id');
        $roomTypeId = $request->room_type_id ?? session('room_type_id');
        $guestsCount = $request->guests ?? session('guests_count', 1);

        $checkin = $request->checkin ?? session('checkin');
        $checkout = $request->checkout ?? session('checkout');

        if (!$hotelId || !$roomTypeId) {
            return redirect()->back()->with('error', 'Please select a hotel, room type, and dates.');
        }

        session([
            'hotel_id'     => $hotelId,
            'room_type_id' => $roomTypeId,
            'guests_count' => $guestsCount,
            'checkin'      => $checkin,
            'checkout'     => $checkout,
        ]);

        $hotel = Hotel::findOrFail($hotelId);
        $roomType = HotelRoomType::findOrFail($roomTypeId);

        $roomData = HotelRoom::where('hotel_id', $hotelId)
            ->where('type_id', $roomType->type_id)
            ->first();

        $price = $roomData ? $roomData->charges : 0;
        $userDetail = \App\Models\UserDetail::where('user_id', \Auth::id())->first();
        $otherGuests = session('other_guests', []);

        return view('userpage.booking.hotel.confirmation', compact(
            'hotel',
            'roomType',
            'userDetail',
            'otherGuests',
            'guestsCount',
            'price',
            'checkin',
            'checkout'
        ));
    }

    // ↓↓↓ このメソッドが消えていたので復活させます ↓↓↓
    public function payment(Request $request)
    {
        $hotelId = $request->hotel_id ?? session('hotel_id');
        $roomTypeId = $request->room_type_id ?? session('room_type_id');
        $guests = $request->guests ?? session('guests_count', 1);

        if (!$hotelId || !$roomTypeId) {
            return redirect()->route('hotels.index')->with('error', 'Session timeout. Please select a room again.');
        }

        $hotel = Hotel::find($hotelId);
        $roomType = HotelRoomType::find($roomTypeId);

        if (!$hotel || !$roomType) {
            return redirect()->route('hotels.index')->with('error', 'Information not found.');
        }

        $roomData = HotelRoom::where('hotel_id', $hotel->id)
            ->where('type_id', $roomType->type_id)
            ->first();

        $price = $roomData ? $roomData->charges : 0;
        $totalPrice = $price * $guests;

        return view('userpage.booking.hotel.payment', compact('hotel', 'roomType', 'guests', 'price', 'totalPrice'));
    }


    public function confirmReservation(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer|exists:hotels,id',
            'room_type_id' => 'required|integer|exists:hotel_room_types,id',
            'guests' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hotel = Hotel::findOrFail($request->hotel_id);
        $roomType = HotelRoomType::findOrFail($request->room_type_id);

        // 実際の部屋（hotel_rooms）を取得する
        $roomData = HotelRoom::where('hotel_id', $hotel->id)
            ->where('type_id', $roomType->type_id)
            ->first();

        if (! $roomData) {
            return redirect()->route('hotel.mypage.hotel')->with('error', 'No room available for selected type.');
        }

        // Booked の id を動的に取得（存在しなければ 3 を使う）
        $bookedId = DB::table('statuses')->where('name', 'Booked')->value('id') ?? 3;

        DB::beginTransaction();
        try {
            $reservation = new HotelReservation();
            $reservation->reservation_id = 'RES' . time() . rand(100, 999);
            $reservation->user_id    = $user->id;
            $reservation->hotel_id   = $hotel->id;
            $reservation->room_id    = $roomData->id; // ← 実部屋の id をセット
            $reservation->guests     = $request->guests;

            $pricePerPerson = $roomData->charges ?? 0;
            $reservation->total_price = $pricePerPerson * $request->guests;

            $otherGuests = session('other_guests', []);
            $reservation->other = json_encode(['additional_guests' => $otherGuests]);

            $reservation->status_id = $bookedId;

            $reservation->start_at  = $request->input('start_at');
            $reservation->end_at    = $request->input('end_at');

            $reservation->save();

            // App/Http/Controllers/HotelReservationController.php

            DB::commit();

            // セッションを忘れずにクリア
            session()->forget(['other_guests', 'hotel_id', 'room_type_id', 'guests_count']);

            // 【ここが重要】 user. を必ずつける
            return redirect()->route('user.reservation.success', [
                'reservation_id' => $reservation->reservation_id
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Reservation create failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Reservation failed. Please try again.');
        }
    }







    // HotelReservationController.php


    public function showPaymentForm(Request $request)
    {
        // GETでもPOSTでも値を受け取れるようにする
        $hotelId = $request->hotel_id ?? null;
        $roomTypeId = $request->room_type_id ?? null;
        $guests = $request->guests ?? null;

        // DBから取得（存在しなくても null でOK）
        $hotel = $hotelId ? Hotel::find($hotelId) : null;
        $roomType = $roomTypeId ? HotelRoomType::find($roomTypeId) : null;

        // Bladeに渡す
        return view('userpage.booking.hotel.payment', compact('hotel', 'roomType', 'guests'));
    }
    public function pay(Request $request)
    {
        // 1. バリデーション（Payment画面から送られてくる項目に合わせる）
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:hotel_room_types,id',
            'guests' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $user = Auth::user();
        $hotel = Hotel::findOrFail($request->hotel_id);
        $roomType = HotelRoomType::findOrFail($request->room_type_id);

        // 実際の部屋を取得
        $roomData = HotelRoom::where('hotel_id', $hotel->id)
            ->where('type_id', $roomType->type_id)
            ->first();

        if (!$roomData) {
            return redirect()->back()->with('error', 'No room available.');
        }

        DB::beginTransaction();
        try {
            $reservation = new HotelReservation();
            $reservation->reservation_id = 'RES' . time() . rand(100, 999);
            $reservation->user_id    = $user->id;
            $reservation->hotel_id   = $hotel->id;
            $reservation->room_id    = $roomData->id;
            $reservation->guests     = $request->guests;
            $reservation->total_price = ($roomData->charges ?? 0) * $request->guests;

            $otherGuests = session('other_guests', []);
            $reservation->other = json_encode(['additional_guests' => $otherGuests]);

            $reservation->status_id = DB::table('statuses')->where('name', 'Booked')->value('id') ?? 3;
            $reservation->start_at  = $request->start_at;
            $reservation->end_at    = $request->end_at;

            $reservation->save();
            DB::commit();

            // セッションクリア
            session()->forget(['other_guests', 'hotel_id', 'room_type_id', 'guests_count', 'checkin', 'checkout']);

            // 成功画面へ
            return redirect()->route('user.reservation.success');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Reservation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process reservation.');
        }
    }

    public function reservationSuccess(Request $request)
    {
        // リクエストパラメータ（URLの ?reservation_id=...）から取得
        $reservationId = $request->query('reservation_id');

        // 予約データを取得
        $reservation = HotelReservation::where('reservation_id', $reservationId)->first();
        $hotel = $reservation ? $reservation->hotel : null;

        return view('userpage.booking.hotel.reservation-success', compact('reservation', 'hotel'));
    }
    public function cancelConfirm(string $reservationId)
    {
        $reservation = HotelReservation::with(['hotel'])
            ->where('reservation_id', $reservationId)
            ->where('user_id', Auth::id()) // 他人の予約は触れない
            ->firstOrFail();

        // すでにキャンセル済みなら一覧に戻す
        $canceledId = DB::table('statuses')->where('name', 'Canceled')->value('id');
        if ($reservation->status_id === $canceledId) {
            return redirect()->route('user.mypage')
                ->with('error', 'この予約はすでにキャンセル済みです。');
        }

        return view('userpage.booking.hotel.cancel-confirm', compact('reservation'));
    }

    /**
     * キャンセル実行
     */
    public function cancel(Request $request, string $reservationId)
    {
        $reservation = HotelReservation::where('reservation_id', $reservationId)
            ->where('user_id', Auth::id()) // 他人の予約は触れない
            ->firstOrFail();

        // statuses テーブルから 'Canceled'(id=5) を取得
        $canceledId = DB::table('statuses')->where('name', 'Canceled')->value('id');

        if (!$canceledId) {
            return redirect()->route('user.mypage')
                ->with('error', 'キャンセル処理に失敗しました。管理者にお問い合わせください。');
        }

        // すでにキャンセル済みなら何もしない
        if ($reservation->status_id === $canceledId) {
            return redirect()->route('user.mypage')
                ->with('error', 'この予約はすでにキャンセル済みです。');
        }

        DB::beginTransaction();
        try {
            $reservation->status_id = $canceledId;
            $reservation->save();

            DB::commit();

            return redirect()->route('user.mypage')
                ->with('success', '予約をキャンセルしました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Reservation cancel failed: ' . $e->getMessage());
            return redirect()->route('user.mypage')
                ->with('error', 'キャンセルに失敗しました。もう一度お試しください。');
        }
    }
}
