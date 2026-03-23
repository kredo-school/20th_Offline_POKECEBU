{{-- resources/views/userpage/mypage/restaurant-search-result.blade.php --}}
@extends('layouts.user')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        if (!function_exists('restaurant_image_url')) {
            function restaurant_image_url($restaurant)
            {
                $img = optional(optional($restaurant->restaurantImages)->first())->image ?? null;
                if (!$img) {
                    return asset('images/placeholder-restaurant.png');
                }
                return preg_match('/^https?:\\/\\//', $img) ? $img : asset('storage/' . ltrim($img, '/'));
            }
        }

        $restaurants = $restaurants ?? collect();
        $amenities = $amenities ?? collect();
        $guestOptions = $guestOptions ?? range(1, 10);
    @endphp

    <div class="container">
        <div class="top-photo">
            <h1>Find Your Perfect Restaurant</h1>
        </div>
        <!-- Search Bar -->
        <div class="mb-4">
            <form class="row g-2 align-items-center" method="get" action="{{ route('user.restaurants.search') }}">
                <div class="col-md-3">
                    <input type="text" name="destination" class="form-control" placeholder="Destination (city)"
                        value="{{ request('destination') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-3">
                    <input type="time" name="time" class="form-control" value="{{ request('time') }}">
                </div>

                {{-- <div class="col-md-2">
                    <select name="tables" class="form-select">
                        <option value="">Tables</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ request('tables') == $i ? 'selected' : '' }}>
                                {{ $i }} table{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div> --}}

                <div class="col-md-2">
                    <select id="guests" name="guests" class="form-select">
                        <option value="">Select number of guests</option>
                        @foreach ($guestOptions as $g)
                            <option value="{{ $g }}"
                                {{ (string) old('guests', request('guests')) === (string) $g ? 'selected' : '' }}>
                                {{ $g }} {{ $g > 1 ? 'people' : 'person' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary" aria-label="Search">
                        <i class="fa-solid fa-utensils"></i>
                    </button>
                </div>
            </form>

            @if (session('error'))
                <div class="alert alert-warning mt-2">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <aside class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-utensils"></i>Filters</h6>

                        <form id="filters-form" method="get" action="{{ route('user.restaurants.search') }}">
                            <input type="hidden" name="destination" value="{{ request('destination') }}">
                            <input type="hidden" name="date" value="{{ request('date') }}">
                            <input type="hidden" name="time" value="{{ request('time') }}">
                            {{-- <input type="hidden" name="tables" value="{{ request('tables') }}"> --}}
                            <input type="hidden" name="guests" value="{{ request('guests') }}">

                            @foreach ($amenities as $amenity)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="amenity-{{ $amenity->id }}"
                                        name="amenities[]" value="{{ $amenity->id }}"
                                        {{ in_array($amenity->id, (array) request('amenities', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="amenity-{{ $amenity->id }}">{{ $amenity->name }}</label>
                                </div>
                            @endforeach
                            <div class="mt-3 d-grid">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Apply Filters</button>
                            </div>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                try {
                                    const navEntries = performance.getEntriesByType && performance.getEntriesByType('navigation');
                                    const isReload = navEntries && navEntries.length && navEntries[0].type === 'reload';
                                    // 古いブラウザ向けフォールバック
                                    const perfNav = performance.navigation && performance.navigation.type === 1;

                                    if (isReload || perfNav) {
                                        const base = location.protocol + '//' + location.host + location.pathname;
                                        // 履歴を置き換えてからリダイレクト（履歴を汚さない）
                                        history.replaceState(null, '', base);
                                        location.replace(base);
                                    }
                                } catch (e) {
                                    // 念のためエラーは無視
                                    console.warn('Refresh detection failed', e);
                                }
                            });
                        </script>

                        <hr>

                        <div class="mb-2">
                            <label class="form-label fw-bold small">Sort by</label>
                            <select class="form-select" name="sort" form="filters-form"
                                onchange="document.getElementById('filters-form').submit()">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>
                                    Recommended</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price:
                                    Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Price: High to Low</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating
                                </option>
                            </select>
                        </div>


                    </div>
                </div>
            </aside>

            <!-- Main results -->
            <main class="col-md-9">
                <div class="row g-3">
                    @forelse($restaurants as $restaurant)
                        {{-- 各カードは col-12 でラップ（1列表示） --}}
                        <div class="col-12">
                            <div class="card mb-3 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        {{-- 画像を左に --}}
                                        <img src="{{ $restaurant->image_path }}"
                                            class="img-fluid rounded-start w-100" alt="{{ $restaurant->name }}"
                                            style="height:220px; object-fit:cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            {{-- 左: 名前・場所 / 右: レビューバッジ（上）と価格（下） --}}
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="card-title mb-1 fw-bold">{{ $restaurant->name }}</h5>
                                                    <div class="small text-muted">
                                                        <i
                                                            class="fa-solid fa-location-dot me-1"></i>{{ $restaurant->city ?? $restaurant->address }}
                                                    </div>

                                                    @php
                                                        // コントローラで withCount / withAvg を付与している前提
                                                        $reviewsCount = $restaurant->reviews_count ?? 0;
                                                        $avg = $restaurant->reviews_avg_rating
                                                            ? number_format($restaurant->reviews_avg_rating, 1)
                                                            : null;
                                                    @endphp

                                                    @if ($reviewsCount > 0)
                                                        <div class="d-flex align-items-center mt-1" aria-label="{{ $reviewsCount }} reviews">
                                                            @if ($avg)
                                                                <span class="me-1 text-dark" style="font-size: 0.8rem;">{{ $avg }}</span>
                                                                <div class="me-1" style="font-size: 0.8rem;">
                                                                    @php
                                                                        $rating = (float)$avg;
                                                                        $fullStars = floor($rating);
                                                                        $halfStar = ($rating - $fullStars >= 0.5) ? 1 : 0;
                                                                        $emptyStars = 5 - $fullStars - $halfStar;
                                                                    @endphp
                                                                    @for($i=0; $i<$fullStars; $i++)
                                                                        <i class="fa-solid fa-star text-warning"></i>
                                                                    @endfor
                                                                    @if($halfStar)
                                                                        <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                                    @endif
                                                                    @for($i=0; $i<$emptyStars; $i++)
                                                                        <i class="fa-solid fa-star" style="color: #d3d3d3;"></i>
                                                                    @endfor
                                                                </div>
                                                            @endif
                                                            <span class="text-secondary" style="font-size: 0.9rem;">({{ $reviewsCount }})</span>
                                                        </div>
                                                    @else
                                                        <div class="small text-muted mt-1">No reviews</div>
                                                    @endif
                                                </div>

                                                <div class="text-end">
                                                    @php
                                                        $tables = $restaurant->tables ?? collect();
                                                        if (request('sort') === 'price_desc') {
                                                            $priceRaw = $restaurant->max_price ?? ($tables->count() ? $tables->max('charges') : null);
                                                        } else {
                                                            $priceRaw = $restaurant->min_price ?? ($tables->count() ? $tables->min('charges') : null);
                                                        }

                                                        $displayPrice =
                                                            $priceRaw !== null
                                                                ? number_format((float) $priceRaw, 2)
                                                                : null;
                                                        $available = $restaurant->available_tables_count ?? null;
                                                    @endphp

                                                    @if ($tables->count() === 0)
                                                        <div class="h6 mb-0 text-muted">No tables</div>
                                                        <div class="small text-muted">Table information has not yet been registered.</div>
                                                    @else
                                                        @if ($available !== null && (int) $available <= 0)
                                                            <div class="h6 mb-0 text-danger">Sold out</div>
                                                            <div class="small text-muted">No available tables for selected time</div>
                                                        @elseif ($displayPrice !== null)
                                                            <div class="h5 mb-0">₱{{ $displayPrice }}~</div>
                                                            <div class="small text-muted">per booking</div>
                                                        @else
                                                            <div class="h6 mb-0 text-muted">Price unavailable</div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- 下段：説明・ボタン・favorite・合計いいね数 --}}
                                            <p class="card-text text-muted mt-2 mb-2">
                                                {{ \Illuminate\Support\Str::limit($restaurant->description ?? '', 140) }}
                                            </p>

                                            <div class="d-flex gap-2 align-items-center">
                                                <a href="{{ route('user.restaurants.detail', $restaurant->id) }}"
                                                    class="btn btn-outline-secondary btn-sm">Details</a>

                                                <div class="ms-3 d-inline-flex align-items-center gap-2">
                                                    @if ($restaurant->isFavorited())
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.destroy', ['restaurant', $restaurant->id]) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-favorite btn p-0" type="submit"
                                                                aria-label="Unfavorite">
                                                                <i class="fa-solid fa-heart text-danger align-middle"
                                                                    style="font-size:1rem;"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-favorite btn p-0" type="submit"
                                                                aria-label="Favorite">
                                                                <i class="fa-regular fa-heart align-middle"
                                                                    style="font-size:1rem;"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- 合計いいね数 --}}
                                                    <div class="favorites-count small text-muted align-middle"
                                                        data-count="{{ $restaurant->favorites_count ?? 0 }}">
                                                        <span
                                                            class="d-inline-block align-middle">{{ $restaurant->favorites_count ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No matching restaurants were found.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    @if (method_exists($restaurants, 'firstItem'))
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                            <div class="mb-2 mb-sm-0 text-muted">
                                @if ($restaurants->total() > 0)
                                    Showing <strong>{{ $restaurants->firstItem() }}</strong> to
                                    <strong>{{ $restaurants->lastItem() }}</strong> of
                                    <strong>{{ $restaurants->total() }}</strong> results
                                @else
                                    No results found
                                @endif
                            </div>

                            <nav aria-label="Search results pages">
                                {{ $restaurants->withQueryString()->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    @else
                        <nav aria-label="Search results pages">
                            {{ $restaurants->withQueryString()->links('pagination::bootstrap-5') }}
                        </nav>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <style>
        .top-photo {
            width: 100%;
            height: 200px;
            margin-bottom: 20px;
            background-image: url("{{ asset('images/home-restaurant.jpg') }}");
            background-size: cover;
            background-position: center 75%;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
            background-blend-mode: multiply;
        }

        .top-photo h1 {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            margin: 0;
            position: relative;
            z-index: 2;
        }
    </style>
@endsection
