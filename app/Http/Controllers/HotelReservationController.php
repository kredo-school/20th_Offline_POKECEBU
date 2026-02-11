<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\HotelReservation;
use App\Models\HotelRoom;

use Illuminate\Support\Facades\Auth;


class HotelReservationController extends Controller
{
    public function index()
    {
        return view('reservations.hotel');
    }
    
    // sutffの予約詳細確認用
    public function show($id) {
        $reservation = HotelReservation::with([
            'user.detail',
            'room'
        ])->findOrFail($id);

        return view('staffpage.reservations.hotel-detail',compact('reservation')
        );
    }
    public function confirmation()
    {
        $hotelId = session('hotel_id');
        $roomTypeId = session('room_type_id'); // ここには HotelRoomType の "id" が入っている想定
        $guestsCount = session('guests_count', 1);

        if (!$hotelId || !$roomTypeId) {
            return redirect()->route('hotels.index');
        }

        $hotel = Hotel::find($hotelId);

        // 1. まず選択された部屋タイプ（HotelRoomType）を確実に取得
        $roomType = HotelRoomType::find($roomTypeId);

        if (!$roomType) {
            // 部屋タイプが見つからない場合の安全策
            return redirect()->route('hotels.index')->with('error', 'Room type not found.');
        }

        // 2. HotelRoom から価格を取得
        // ポイント：確実に hotel_id と type_id (1=single, 2=doubleなど) で絞り込む
        $roomData = HotelRoom::where('hotel_id', $hotelId)
            ->where('type_id', $roomType->type_id)
            ->first();

        // デバッグ用（もし画面が真っ白になって ID が出たら、その数字をDBと見比べてみて！）
        // dd('HotelID:'.$hotelId, 'TypeID:'.$roomType->type_id);

        $price = $roomData ? $roomData->charges : 0;

        $userDetail = \App\Models\UserDetail::where('user_id', Auth::id())->first();
        $otherGuests = session('other_guests', []);

        return view('userpage.booking.hotel.confirmation', compact(
            'hotel',
            'roomType',
            'userDetail',
            'otherGuests',
            'guestsCount',
            'price'
        ));
    }

    public function payment(Request $request)
    {
        $hotel = Hotel::findOrFail($request->hotel_id);
        $roomType = HotelRoomType::findOrFail($request->room_type_id);

        // 支払い画面でも価格を再取得（またはhiddenで受け取る）
        $roomData = HotelRoom::where('hotel_id', $hotel->id)
            ->where('type_id', $roomType->type_id)
            ->first();
        $price = $roomData ? $roomData->charges : 0;

        $guests = $request->guests;
        $totalPrice = $price * $guests; // 合計金額

        return view('userpage.booking.hotel.payment', compact('hotel', 'roomType', 'guests', 'price', 'totalPrice'));
    }

    // 予約確定
    public function confirmReservation(Request $request)
    {
        $user = Auth::user();
        $hotel = Hotel::find($request->hotel_id);
        $roomType = HotelRoomType::find($request->room_type_id);

        $userDetail = session('user_detail', []);
        $otherGuests = session('other_guests', []);

        // 予約作成
        $reservation = new HotelReservation();
        $reservation->user_id = $user->id;
        $reservation->hotel_id = $hotel->id;
        $reservation->room_id = $roomType->id ?? null;
        $reservation->guests = $request->guests;
        $reservation->user_name = $userDetail['first_name'] . ' ' . $userDetail['last_name'];
        $reservation->user_email = $userDetail['email'] ?? '';
        $reservation->user_phone = $userDetail['phone'] ?? '';
        $reservation->other = json_encode($otherGuests);
        $reservation->save();

        // セッションをクリア
        $request->session()->forget(['user_detail', 'other_guests']);

        // 成功画面へ
        return redirect()->route('reservation.success', ['reservation_id' => $reservation->id]);
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
        // ⚠️ 入力何でもOK
        $inputs = $request->all();
        logger($inputs); // 入力をログに残すだけ

        // roomType があれば取得する（無ければ null）
        $roomType = !empty($request->room_type_id) ? HotelRoomType::find($request->room_type_id) : null;
        $hotel = !empty($request->hotel_id) ? Hotel::find($request->hotel_id) : null;

        // 本来のPayPal処理はスキップ、成功画面に飛ばす
        return view('userpage.booking.hotel.reservation-success', compact('inputs', 'hotel', 'roomType'));
    }

    public function reservationSuccess(Request $request)
    {
        // セッションやリクエストから入力を取得（なければ空配列）
        $inputs = $request->all() ?: [];

        // ホテル情報なども必要なら取得しますが、一旦エラー回避を優先
        $hotel = null;
        $roomType = null;

        return view('userpage.booking.hotel.reservation-success', compact('inputs', 'hotel', 'roomType'));
    }
}

