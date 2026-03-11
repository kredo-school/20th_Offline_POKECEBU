<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantTable;

use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class RestaurantController extends Controller
{
    public function index()
    {
        $restaurant = [
            'name' => 'Ocean Breeze Restaurant',
            'location' => 'Cebu City',
            'price' => 3500,
            'image' => 'https://via.placeholder.com/800x400'
        ];

        return view('userpage.booking.restaurant', compact('restaurant'));
    }

    public function search(SearchRequest $request)
    {
        // 入力パラメータ（レストラン向け）
        $date = $request->input('date');           // 例: 2026-03-10
        $time = $request->input('time');           // 例: 19:00
        $guests = (int) $request->input('guests', 0);
        $tablesNeeded = (int) $request->input('tables', 0);
        $categories = (array) $request->input('categories', []);
        $destination = $request->input('destination');
        $sort = $request->input('sort');

        // guestOptions（テーブルの max_guests を一覧化）
        $guestOptions = \App\Models\RestaurantTable::orderBy('max_guests')
            ->pluck('max_guests')
            ->unique()
            ->values();

        // サーバ側バリデーション（guests）
        if ($request->isMethod('get') && $request->filled('guests')) {
            $allowed = $guestOptions->map(fn($v) => (string)$v)->toArray();
            $request->validate([
                'guests' => ['nullable', 'in:' . implode(',', $allowed)],
            ]);
        }

        // --- ベースクエリ（ここではまだ paginate を呼ばない） ---
        $query = \App\Models\Restaurant::query();

        // destination（city / address / name）
        if ($destination) {
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'like', "%{$destination}%")
                    ->orWhere('address', 'like', "%{$destination}%")
                    ->orWhere('name', 'like', "%{$destination}%");
            });
        }

        // 人数フィルタ（テーブルの max_guests を参照）
        if ($guests > 0) {
            $query->whereHas('tables', function ($q) use ($guests) {
                $q->where('max_guests', '>=', $guests);
            });
        }

        // 日付と時間が指定されている場合は空席（空テーブル）で絞る
        $startDateTime = $endDateTime = null;
        if ($tablesNeeded > 0 && ($date || $time)) {
            try {
                $dt = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::today();
                $t = $time ? \Carbon\Carbon::parse($time)->format('H:i:s') : '19:00:00';
                $startDateTime = \Carbon\Carbon::parse($dt->toDateString() . ' ' . $t);
                $endDateTime = (clone $startDateTime)->addHours(2);
            } catch (\Exception $e) {
                session()->flash('error', 'Please enter a valid date and time format.');
                $query->whereRaw('0 = 1');
            }

            if (!empty($startDateTime) && !empty($endDateTime)) {
                if ($startDateTime->gt($endDateTime)) {
                    session()->flash('error', 'Please specify a start date and time that is before the end date and time.');
                    $query->whereRaw('0 = 1');
                } elseif ($endDateTime->lt(now()->startOfDay())) {
                    session()->flash('error', 'Searches for past dates and times are not possible.');
                    $query->whereRaw('0 = 1');
                } else {
                    $bookedId = DB::table('statuses')->where('name', 'Booked')->value('id') ?? 3;

                    // テーブルに予約が重なっていないレストランを残す
                    $query->whereHas('tables', function ($q) use ($startDateTime, $endDateTime, $bookedId) {
                        $q->whereDoesntHave('reservations', function ($r) use ($startDateTime, $endDateTime, $bookedId) {
                            $r->where('status_id', $bookedId)
                                ->whereRaw('NOT (end_at < ? OR start_at > ?)', [
                                    $startDateTime->toDateTimeString(),
                                    $endDateTime->toDateTimeString()
                                ]);
                        });
                    });

                    // 相関サブクエリで空きテーブル数を評価して絞る
                    $sStr = $startDateTime->toDateTimeString();
                    $eStr = $endDateTime->toDateTimeString();

                    $availableTablesSub = "
                    SELECT COUNT(*) FROM restaurant_tables rt
                    WHERE rt.restaurant_id = restaurants.id
                      AND NOT EXISTS (
                        SELECT 1 FROM restaurant_reservations r
                        WHERE r.table_id = rt.id
                          AND r.status_id = ?
                          AND NOT (r.end_at < ? OR r.start_at > ?)
                      )
                ";

                    $query->whereRaw("({$availableTablesSub}) >= ?", [
                        $bookedId,
                        $sStr,
                        $eStr,
                        $tablesNeeded
                    ]);

                    // min_price サブクエリ（期間指定時）
                    $minPriceSub = "(
                    SELECT MIN(rt2.charges)
                    FROM restaurant_tables rt2
                    WHERE rt2.restaurant_id = restaurants.id
                      AND NOT EXISTS (
                        SELECT 1 FROM restaurant_reservations r2
                        WHERE r2.table_id = rt2.id
                          AND r2.status_id = {$bookedId}
                          AND NOT (r2.end_at < '{$sStr}' OR r2.start_at > '{$eStr}')
                      )
                )";

                    // addSelect は後でまとめて行うためここで変数に保持
                }
            } else {
                session()->flash('error', 'Please specify both the date and time.');
                $query->whereRaw('0 = 1');
            }
        }

        // カテゴリ（料理ジャンル等）を AND 条件で適用
        if (!empty($categories)) {
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories.id', $categories);
            });
        }

        // --- デフォルトの minPrice サブクエリ（必ず定義しておく） ---
        $defaultMinPriceSub = "(
        SELECT MIN(rt.charges)
        FROM restaurant_tables rt
        WHERE rt.restaurant_id = restaurants.id
    )";

        // ここで select を明示し、min_price を付与する
        $query->select('restaurants.*');
        // もし期間指定で上書きした $minPriceSub があればそれを使い、なければデフォルト
        if (isset($minPriceSub) && !empty($minPriceSub)) {
            $query->addSelect(DB::raw("({$minPriceSub}) as min_price"));
        } else {
            $query->addSelect(DB::raw("({$defaultMinPriceSub}) as min_price"));
        }

        // ソート
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw("({$defaultMinPriceSub}) ASC");
                break;
            case 'price_desc':
                $query->orderByRaw("({$defaultMinPriceSub}) DESC");
                break;
            case 'rating':
                $query->orderByDesc('star_rating');
                break;
            default:
                $query->latest('id');
        }

        // 必要なリレーションを eager load、合計いいね数を付与、現在ユーザー分の favorites を絞ってロード
        $query->with(['restaurantImages', 'tables', 'reviews'])
            ->withCount('favorites')
            ->with(['favorites' => function ($q) {
                if ($userId = Auth::id()) {
                    $q->where('user_id', $userId);
                } else {
                    $q->whereRaw('0 = 1');
                }
            }]);


        // 重複削除（必要なら）
        $query->distinct();

        // ページネーション（ここで初めて paginate を呼ぶ）
        $restaurants = $query->paginate(10)->withQueryString();

        // カテゴリ一覧などビュー用データ
        $categoriesList = \App\Models\Category::orderBy('name')->get();

        $guestOptions = range(1, 10);
        $amenities = \App\Models\Category::whereIn('target_type', ['restaurant', 'all'])
            ->orderBy('name', 'asc')
            ->get();

        return view('userpage.mypage.restaurant-search-result', compact('restaurants', 'amenities', 'guestOptions'));
    }



    public function showDetailRestaurant($id)
    {
        $restaurant = Restaurant::with('restaurantImages')->findOrFail($id);

        $tables = RestaurantTable::with(['type', 'status'])
            ->where('restaurant_id', $restaurant->id)
            ->get();


        return view('userpage.booking.detail-restaurant', compact('restaurant', 'tables'));
    }
}
