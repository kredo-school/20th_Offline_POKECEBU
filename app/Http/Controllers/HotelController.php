<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




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
    public function index(SearchRequest $request)
    {
        $ci = $request->input('checkin');
        $co = $request->input('checkout');
        $adults = (int) $request->input('adults', 0);
        $roomsNeeded = (int) $request->input('rooms', 0);
        $amenities = (array) $request->input('amenities', []);

        // -----------------------------
        // 追加: guestOptions を作成（人数プルダウン用）
        // -----------------------------
        $guestOptions = \App\Models\HotelRoom::orderBy('max_guests') // テーブルのカラム名に合わせる
            ->pluck('max_guests')   // 例: [2,3,4,5,6]
            ->unique()
            ->values();

        // -----------------------------
        // 追加: サーバ側バリデーション（adults が許可値のいずれかであること）
        // GET リクエストで adults が送られてきた場合のみ検証
        // -----------------------------
        if ($request->isMethod('get') && $request->filled('adults')) {
            // in: ルールは文字列で渡す
            $allowed = $guestOptions->map(fn($v) => (string)$v)->toArray(); // ['2','3','4',...]
            $request->validate([
                'adults' => ['nullable', 'in:' . implode(',', $allowed)],
                // 必要なら他の検索パラメータのルールをここに追加
            ]);
        }

        $query = Hotel::query()
            ->with(['hotelImages', 'rooms.categories', 'rooms.reservations', 'reviews'])
            ->withCount('favorites');

        // destination（既存の処理）
        if ($destination = $request->input('destination')) {
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'like', "%{$destination}%")
                    ->orWhere('address', 'like', "%{$destination}%")
                    ->orWhere('name', 'like', "%{$destination}%");
            });
        }

        // 人数フィルタ
        if ($adults > 0) {
            $query->whereHas('rooms', function ($q) use ($adults) {
                $q->where('max_guests', '>=', $adults);
            });
        }

        // 日付と部屋数が指定されている場合は空室数で絞る
        if ($roomsNeeded > 0 && $ci && $co) {
            $ciCarbon = Carbon::parse($ci)->startOfDay();
            $coCarbon = Carbon::parse($co)->endOfDay();

            $query->whereHas('rooms', function ($q) use ($ciCarbon, $coCarbon) {
                $q->whereDoesntHave('reservations', function ($r) use ($ciCarbon, $coCarbon) {
                    $r->where(function ($s) use ($ciCarbon, $coCarbon) {
                        $s->whereBetween('start_at', [$ciCarbon, $coCarbon])
                            ->orWhereBetween('end_at', [$ciCarbon, $coCarbon])
                            ->orWhere(function ($u) use ($ciCarbon, $coCarbon) {
                                $u->where('start_at', '<=', $ciCarbon)->where('end_at', '>=', $coCarbon);
                            });
                    });
                });
            })
                ->withCount(['rooms as available_rooms_count' => function ($q) use ($ciCarbon, $coCarbon) {
                    $q->whereDoesntHave('reservations', function ($r) use ($ciCarbon, $coCarbon) {
                        $r->where(function ($s) use ($ciCarbon, $coCarbon) {
                            $s->whereBetween('start_at', [$ciCarbon, $coCarbon])
                                ->orWhereBetween('end_at', [$ciCarbon, $coCarbon])
                                ->orWhere(function ($u) use ($ciCarbon, $coCarbon) {
                                    $u->where('start_at', '<=', $ciCarbon)->where('end_at', '>=', $coCarbon);
                                });
                        });
                    });
                }])
                ->having('available_rooms_count', '>=', $roomsNeeded);
        }

        // amenities フィルタ
        if (!empty($amenities)) {
            $query->whereHas('rooms', function ($q) use ($amenities) {
                $q->whereHas('categories', function ($q2) use ($amenities) {
                    $q2->whereIn('categories.id', $amenities);
                });
            });
        }

        // ソート
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderByRaw('(SELECT MIN(charges) FROM hotel_rooms WHERE hotel_rooms.hotel_id = hotels.id) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('(SELECT MIN(charges) FROM hotel_rooms WHERE hotel_rooms.hotel_id = hotels.id) DESC');
                break;
            case 'rating':
                $query->orderByDesc('star_rating');
                break;
            default:
                $query->latest('id');
        }

        $hotels = $query->paginate(10)->withQueryString();

        $amenitiesList = \App\Models\Category::orderBy('name')->get();

        // -----------------------------
        // 変更: ビューに guestOptions を渡す
        // -----------------------------
        return view('userpage.mypage.hotel-search-result', [
            'hotels' => $hotels,
            'amenities' => $amenitiesList,
            'guestOptions' => $guestOptions, // 追加
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

    // app/Http/Controllers/HotelController.php

    // public function search(Request $request)
    // {
    //     // ビュー用の選択肢を作る（2,3,4,5,6 のような Collection）
    //     $guestOptions = HotelRoom::orderBy('maxguest')
    //         ->pluck('maxguest')
    //         ->unique()
    //         ->values();

    //     // GET で adults が送られてきたら検証する（空許容なら nullable）
    //     if ($request->isMethod('get') && $request->filled('adults')) {
    //         $allowed = $guestOptions->map(fn($v) => (string)$v)->toArray(); // ['2','3','4',...]
    //         $request->validate([
    //             'adults' => ['nullable', 'in:' . implode(',', $allowed)],
    //             // 他の検索パラメータのルールがあればここに追加
    //         ]);
    //     }

    //     // 既存の rooms 取得など
    //     $rooms = HotelRoom::orderBy('name')->get();

    //     return view('userpage.mypage.hotel-search-result', compact('rooms', 'guestOptions'));
    // }
};
