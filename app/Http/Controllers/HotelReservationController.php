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
  
    // sutffの予約詳細確認用
    public function show($id)
    {
        $reservation = HotelReservation::with([
            'user.detail',
            'room'
        ])->findOrFail($id);

        return view(
            'staffpage.reservations.hotel-detail',
            compact('reservation')
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
    // 1. Requestになければセッションから探す（ここが404回避のキモ）
    $hotelId = $request->hotel_id ?? session('hotel_id');
    $roomTypeId = $request->room_type_id ?? session('room_type_id');
    $guests = $request->guests ?? session('guests_count', 1);

    // 2. それでもデータがない時は一覧に戻す（404にしない）
    if (!$hotelId || !$roomTypeId) {
        return redirect()->route('hotels.index')->with('error', 'Session timeout. Please select a room again.');
    }

    // 3. findOrFail ではなく find で取得してチェック（安全策）
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

    // 予約確定
public function confirmReservation(Request $request)
{
    $user = Auth::user();
    
    // 1. まずデータを取得（ここで失敗したら先に進ませない）
    $hotel = Hotel::findOrFail($request->hotel_id);
    $roomType = HotelRoomType::findOrFail($request->room_type_id); // ここで定義！

    // 2. 部屋の価格データを取得
    $roomData = HotelRoom::where('hotel_id', $hotel->id)
                ->where('type_id', $roomType->type_id) // これで赤文字が消えるはず
                ->first();

    // 3. 予約インスタンス作成
    $reservation = new HotelReservation();
    $reservation->reservation_id = 'RES' . time() . rand(100, 999);
    
    $reservation->user_id    = $user->id;
    $reservation->hotel_id   = $hotel->id;
    $reservation->room_id    = $roomType->id; // HotelRoomTypeのID
    $reservation->guests     = $request->guests;

    // 金額計算（roomDataがない場合の安全策）
    $pricePerPerson = $roomData ? $roomData->charges : 0;
    $reservation->total_price = $pricePerPerson * $request->guests;

    // フォームからの情報を保存
   $reservation->user_id = auth()->id();

    // 追加ゲスト（セッションから）
        $otherGuests = session('other_guests', []);
        $reservation->other = json_encode([
            'additional_guests' => $otherGuests,
    ]);

    $reservation->status_id = 1;
    $reservation->start_at  = now();
    $reservation->end_at    = now()->addDays(1);

    // 4. 保存実行
    $reservation->save();

    // 5. セッション削除
    $request->session()->forget(['other_guests']);

    return redirect()->route('reservation.success', [
        'reservation_id' => $reservation->reservation_id
    ]);
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
        dd('pay通ってる');

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
