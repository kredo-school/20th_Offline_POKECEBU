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
        $amenities = (array) $request->input('amenities', []);
        $destination = $request->input('destination');
        $sort = $request->input('sort');

        // guestOptions（テーブルの max_guests を一覧化）
        $guestOptions = RestaurantTable::orderBy('max_guests')
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
        if ($date || $time) {
            try {
                $dt = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::today();
                $t = $time ? \Carbon\Carbon::parse($time)->format('H:i:s') : '19:00:00';
                $startDateTime = \Carbon\Carbon::parse($dt->toDateString() . ' ' . $t);
                $endDateTime = (clone $startDateTime)->addHours(2); // 滞在時間は必要に応じて調整
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
                    // Booked ステータス ID（なければデフォルト 3）
                    $bookedId = DB::table('statuses')->where('name', 'Booked')->value('id') ?? 3;

                    $sStr = $startDateTime->toDateTimeString();
                    $eStr = $endDateTime->toDateTimeString();

                    // 「期間内に予約が重なっていないテーブルが1つでもあるレストラン」を残す
                    $query->whereHas('tables', function ($q) use ($sStr, $eStr, $bookedId) {
                        $q->whereDoesntHave('reservations', function ($r) use ($sStr, $eStr, $bookedId) {
                            $r->where('status_id', $bookedId)
                                ->whereRaw('NOT (end_at < ? OR start_at > ?)', [$sStr, $eStr]);
                        });
                    });

                    // 期間指定時の min_price を相関サブクエリで上書き（任意）
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
                    $maxPriceSub = "(
                    SELECT MAX(rt2.charges)
                    FROM restaurant_tables rt2
                    WHERE rt2.restaurant_id = restaurants.id
                      AND NOT EXISTS (
                        SELECT 1 FROM restaurant_reservations r2
                        WHERE r2.table_id = rt2.id
                          AND r2.status_id = {$bookedId}
                          AND NOT (r2.end_at < '{$sStr}' OR r2.start_at > '{$eStr}')
                      )
                )";
                }
            } else {
                session()->flash('error', 'Please specify both the date and time.');
                $query->whereRaw('0 = 1');
            }
        }

        // amenities を AND 条件で適用（各テーブルが全てのカテゴリを持つ）
        if (!empty($amenities)) {
            $query->whereHas('tables', function ($q) use ($amenities) {
                foreach ($amenities as $amenityId) {
                    $q->whereHas('categories', function ($q2) use ($amenityId) {
                        $q2->where('categories.id', $amenityId);
                    });
                }
            });
        }

        // --- デフォルトの minPrice / maxPrice サブクエリ（必ず定義しておく） ---
        $defaultMinPriceSub = "(
        SELECT MIN(rt.charges)
         FROM restaurant_tables rt
         WHERE rt.restaurant_id = restaurants.id
         )";
        $defaultMaxPriceSub = "(
        SELECT MAX(rt.charges)
         FROM restaurant_tables rt
         WHERE rt.restaurant_id = restaurants.id
         )";

        // ここで select を明示し、min_price / max_price を付与する
        $query->select('restaurants.*');
        if (isset($minPriceSub) && !empty($minPriceSub)) {
            $query->addSelect(DB::raw("({$minPriceSub}) as min_price"));
            $query->addSelect(DB::raw("({$maxPriceSub}) as max_price"));
        } else {
            $query->addSelect(DB::raw("({$defaultMinPriceSub}) as min_price"));
            $query->addSelect(DB::raw("({$defaultMaxPriceSub}) as max_price"));
            $minPriceSub = $defaultMinPriceSub;
            $maxPriceSub = $defaultMaxPriceSub;
        }

        // ソート
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw("({$minPriceSub}) IS NULL, ({$minPriceSub}) ASC");
                break;
            case 'price_desc':
                $query->orderByRaw("({$maxPriceSub}) IS NULL, ({$maxPriceSub}) DESC");
                break;
            case 'rating':
                $query->orderByRaw('reviews_avg_rating IS NULL, reviews_avg_rating DESC');
                break;
            default:
                $query->latest('id');
        }

        // 必要なリレーションを eager load、合計いいね数を付与、現在ユーザー分の favorites を絞ってロード
        $query->with(['restaurantImages', 'tables'])
            ->select('restaurants.*')
            ->withCount('favorites')
            // reviews を reservation 経由で集計する相関サブクエリを追加
            ->selectRaw('(SELECT COUNT(*) FROM reviews r JOIN restaurant_reservations rr ON r.restaurant_reservation_id = rr.id WHERE rr.restaurant_id = restaurants.id) as reviews_count')
            ->selectRaw('(SELECT AVG(r.rating) FROM reviews r JOIN restaurant_reservations rr ON r.restaurant_reservation_id = rr.id WHERE rr.restaurant_id = restaurants.id) as reviews_avg_rating')
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
