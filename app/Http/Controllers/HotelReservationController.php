<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\HotelReservation;
use App\Models\HotelRoom;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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
            return redirect()->route('hotels.index')->with('error', 'No room available for selected type.');
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

            DB::commit();

            $request->session()->forget(['other_guests']);

            return redirect()->route('reservation.success', [
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
