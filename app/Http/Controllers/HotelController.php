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

use Illuminate\Support\Facades\DB;




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

        // guestOptions
        $guestOptions = \App\Models\HotelRoom::orderBy('max_guests')
            ->pluck('max_guests')
            ->unique()
            ->values();

        // サーバ側バリデーション（adults）
        if ($request->isMethod('get') && $request->filled('adults')) {
            $allowed = $guestOptions->map(fn($v) => (string)$v)->toArray();
            $request->validate([
                'adults' => ['nullable', 'in:' . implode(',', $allowed)],
            ]);
        }

        // ベースクエリ（withCount は残す）
        $query = Hotel::query()
            ->with(['hotelImages', 'rooms.categories', 'rooms.reservations', 'reviews'])
            ->withCount('favorites');

        // destination
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
        $ciCarbon = $coCarbon = null;
        if ($roomsNeeded > 0 && ($ci || $co)) {
            try {
                $ciCarbon = $ci ? Carbon::parse($ci)->startOfDay() : null;
                $coCarbon = $co ? Carbon::parse($co)->endOfDay() : null;
            } catch (\Exception $e) {
                session()->flash('error', '日付の形式が正しくありません。');
                $query->whereRaw('0 = 1'); // 空結果
            }

            if (!empty($ciCarbon) && !empty($coCarbon)) {
                if ($ciCarbon->gt($coCarbon)) {
                    session()->flash('error', 'チェックインはチェックアウト以前の日付を指定してください。');
                    $query->whereRaw('0 = 1');
                } elseif ($coCarbon->lt(now()->startOfDay())) {
                    session()->flash('error', '過去の日付での検索はできません。');
                    $query->whereRaw('0 = 1');
                } else {
                    // Booked の status_id を動的に取得
                    $bookedId = DB::table('statuses')->where('name', 'Booked')->value('id') ?? 3;

                    // rooms のうち「指定期間に Booked の予約が重なっていない部屋」を残す（AND 条件）
                    $query->whereHas('rooms', function ($q) use ($ciCarbon, $coCarbon, $bookedId) {
                        $q->whereDoesntHave('reservations', function ($r) use ($ciCarbon, $coCarbon, $bookedId) {
                            $r->where('status_id', $bookedId)
                                ->whereRaw('NOT (end_at < ? OR start_at > ?)', [
                                    $ciCarbon->toDateTimeString(),
                                    $coCarbon->toDateTimeString()
                                ]);
                        });
                    });

                    // 相関サブクエリで「期間内に空いている部屋数」を評価して絞る（paginate と相性良し）
                    $ciStr = $ciCarbon->toDateTimeString();
                    $coStr = $coCarbon->toDateTimeString();

                    $availableRoomsSub = "
                    SELECT COUNT(*) FROM hotel_rooms hr
                    WHERE hr.hotel_id = hotels.id
                      AND NOT EXISTS (
                        SELECT 1 FROM hotel_reservations r
                        WHERE r.room_id = hr.id
                          AND r.status_id = ?
                          AND NOT (r.end_at < ? OR r.start_at > ?)
                      )
                ";

                    // バインディング順： bookedId, ciStr, coStr, roomsNeeded
                    $query->whereRaw("({$availableRoomsSub}) >= ?", [
                        $bookedId,
                        $ciStr,
                        $coStr,
                        $roomsNeeded
                    ]);

                    // min_price サブクエリ（ビュー表示・ソート用）
                    $minPriceSub = "(
                    SELECT MIN(hr2.charges)
                    FROM hotel_rooms hr2
                    WHERE hr2.hotel_id = hotels.id
                      AND NOT EXISTS (
                        SELECT 1 FROM hotel_reservations r2
                        WHERE r2.room_id = hr2.id
                          AND r2.status_id = {$bookedId}
                          AND NOT (r2.end_at < '{$ciStr}' OR r2.start_at > '{$coStr}')
                      )
                )";

                    // addSelect で min_price を追加（select を上書きしない）
                    $query->addSelect(DB::raw("({$minPriceSub}) as min_price"));
                }
            } else {
                // 片方しか日付がない場合は検索を空にする（要件に応じて緩和可）
                session()->flash('error', 'チェックインとチェックアウトの両方を指定してください。');
                $query->whereRaw('0 = 1');
            }
        }

        // amenities を AND 条件で適用（同じ room が全てのカテゴリを持つ）
        if (!empty($amenities)) {
            $query->whereHas('rooms', function ($q) use ($amenities) {
                foreach ($amenities as $amenityId) {
                    $q->whereHas('categories', function ($q2) use ($amenityId) {
                        $q2->where('categories.id', $amenityId);
                    });
                }
            });
        }

        // 重複行を防ぐ（JOIN による膨張対策）
        $query->distinct();

        // 期間がない場合の min_price（まだ付与されていなければ付与）
        if (!isset($minPriceSub)) {
            $minPriceSub = "(SELECT MIN(hr.charges) FROM hotel_rooms hr WHERE hr.hotel_id = hotels.id)";
            $query->addSelect(DB::raw("({$minPriceSub}) as min_price"));
        }

        // ソート
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderByRaw("{$minPriceSub} ASC");
                break;
            case 'price_desc':
                $query->orderByRaw("{$minPriceSub} DESC");
                break;
            case 'rating':
                $query->orderByDesc('star_rating');
                break;
            default:
                $query->latest('id');
        }

        // ページネーション
        $hotels = $query->paginate(10)->withQueryString();

        $amenitiesList = \App\Models\Category::orderBy('name')->get();

        return view('userpage.mypage.hotel-search-result', [
            'hotels' => $hotels,
            'amenities' => $amenitiesList,
            'guestOptions' => $guestOptions,
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
