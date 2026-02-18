<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;



class HotelController extends Controller
{

    private $hotel;

    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }


    public function showDetailHotel($id)
    {
        $hotel = Hotel::with('hotelImages')->findOrFail($id);
        $rooms = HotelRoom::with(['type', 'status', 'images'])
            ->where('hotel_id', $id)
            ->get();

        return view('userpage.booking.hotel.detail-hotel', compact('hotel', 'rooms'));
    }

    // 上のコードを残す（バックアップ）
    public function sample()
    {
        $hotel = [
            'name' => 'Ocean View Hotel',
            'location' => 'Cebu City',
            'price' => 12000,
            'image' => 'https://via.placeholder.com/800x400'
        ];

        return view('userpage.booking.hotel', compact('hotel'));
    }

    // 実データ一覧表示（新しい index）
    public function index(Request $request)
    {
        // ベースクエリ：必要なリレーションを eager load
        $query = \App\Models\Hotel::query()
            ->with(['hotelImages', 'rooms.roomType', 'rooms.reservations', 'reviews']);

        // 1) 場所（destination）: city または address に部分一致
        if ($dest = trim($request->input('destination', ''))) {
            $dest = mb_strtolower($dest);
            $query->where(function ($q) use ($dest) {
                $q->whereRaw('LOWER(city) LIKE ?', ["%{$dest}%"])
                    ->orWhereRaw('LOWER(address) LIKE ?', ["%{$dest}%"]);
            });
        }


        // 2) 人数（adults）: max_guests 以上の部屋があるホテル
        if ($adults = (int) $request->input('adults')) {
            $query->where(function ($q) use ($adults) {
                $q->whereHas('rooms', function ($r) use ($adults) {
                    $r->where('max_guests', '>=', $adults);
                })->orWhereDoesntHave('rooms');
            });
        }


        // 3) アメニティ（amenities[]）: categories が多対多で繋がっている想定
        if ($amenities = $request->input('amenities')) {
            $query->whereHas('categories', function ($q) use ($amenities) {
                $q->whereIn('categories.id', (array) $amenities);
            });
        }


        // 4) 日付による可用性（checkin, checkout）
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        if ($checkin && $checkout) {
            try {
                $ci = Carbon::parse($checkin)->startOfDay();
                $co = Carbon::parse($checkout)->endOfDay();

                // 「指定期間に空きのある部屋があるホテル」または「部屋が無いホテル」を残す
                $query->where(function ($q) use ($ci, $co) {
                    $q->whereHas('rooms', function ($q2) use ($ci, $co) {
                        $q2->whereDoesntHave('reservations', function ($r) use ($ci, $co) {
                            $r->where(function ($s) use ($ci, $co) {
                                $s->whereBetween('start_at', [$ci, $co])
                                    ->orWhereBetween('end_at', [$ci, $co])
                                    ->orWhere(function ($u) use ($ci, $co) {
                                        $u->where('start_at', '<=', $ci)->where('end_at', '>=', $co);
                                    });
                            });
                        });
                    })->orWhereDoesntHave('rooms');
                });
            } catch (\Exception $e) {
                // 日付パース失敗時は無視（必要ならバリデーションを追加）
            }
        }


        // 5) ソート（price_asc, price_desc, rating, default: created_at desc）
        // rooms_count を取得（部屋数でソートするため）
        $query->withCount('rooms');

        // withMin / withAvg を使って rooms の最小料金や reviews の平均を取得
        $query->withMin('rooms', 'charges')->withAvg('reviews', 'rating');

        // 優先ソート：まず rooms_count（部屋ありを上位）で降順、その後ユーザー指定の sort を適用
        // rooms_count が同じ場合は created_at を降順にする（必要に応じて変更）
        $query->orderByDesc('rooms_count');
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('rooms_min_charges', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('rooms_min_charges', 'desc');
                break;
            case 'rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                // 部屋ありを優先して表示したい場合は下の orderByRaw を使う（コメント解除）
                $query->orderByRaw('(select count(*) from hotel_rooms where hotel_rooms.hotel_id = hotels.id) desc');
                // $query->orderBy('created_at', 'desc');
        }


        // ページネーション（既存は 10 件なので合わせる）
        $hotels = $query->paginate(10)->withQueryString();

        // サイドバー用アメニティ一覧（Category モデルを利用）
        $amenitiesList = \App\Models\Category::orderBy('name')->get();

        return view('userpage.mypage.hotel-search-result', [
            'hotels' => $hotels,
            'amenities' => $amenitiesList,
        ]);
    }

    public function show($id)
    {
        $hotel = \App\Models\Hotel::with([
            'hotelImages',
            'rooms.roomType',   // rooms -> roomType
            'roomTypes.type',   // optional: if you have roomTypes relation
            'reviews',
            'categories'        // amenities / categories
        ])->findOrFail($id);

        return view('userpage.booking.hotel', compact('hotel'));
    }
    public function roomInfo()
    {
        // 仮のホテルIDを固定
        $id = 3; // たぬきホテルなど、DBに存在するID
        $hotel = Hotel::with('roomTypes.roomType')->findOrFail($id);


        return view('userpage.booking.hotel.hotel', compact('hotel'));
    }
};
