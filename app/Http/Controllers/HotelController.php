<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Http\Requests\SearchRequest;




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

        $query = Hotel::query()
            ->with(['hotelImages', 'rooms.categories', 'rooms.reservations', 'reviews'])
            ->withCount('favorites');

        // destination（既存の処理があればそのまま）
        if ($destination = $request->input('destination')) {
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'like', "%{$destination}%")
                    ->orWhere('address', 'like', "%{$destination}%")
                    ->orWhere('name', 'like', "%{$destination}%");
            });
        }

        // 人数フィルタ: 少なくとも1部屋で max_guests >= adults を満たす部屋があるホテル
        if ($adults > 0) {
            $query->whereHas('rooms', function ($q) use ($adults) {
                $q->where('max_guests', '>=', $adults);
            });
        }

        // 日付と部屋数が指定されている場合は空室数で絞る
        if ($roomsNeeded > 0 && $ci && $co) {
            $ciCarbon = Carbon::parse($ci)->startOfDay();
            $coCarbon = Carbon::parse($co)->endOfDay();

            // ホテルに対して「空き部屋がある rooms を持つ」ことを確認し、
            // さらに available_rooms_count を計算して having で絞る
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

        // amenities フィルタ（カテゴリの belongsToMany を想定）
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
                // rooms の最安値でソート（簡易）
                $query->orderByRaw('(SELECT MIN(charges) FROM hotel_rooms WHERE hotel_rooms.hotel_id = hotels.id) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('(SELECT MIN(charges) FROM hotel_rooms WHERE hotel_rooms.hotel_id = hotels.id) DESC');
                break;
            case 'rating':
                $query->orderByDesc('star_rating');
                break;
            default:
                // recommended の場合はデフォルト順
                $query->latest('id');
        }

        $hotels = $query->paginate(10)->withQueryString();

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
