{{-- resources/views/userpage/mypage/hotel-search-result.blade.php --}}
@extends('layouts.user')

@section('content')
    <!-- head に入れる -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        /**
         * Helper: return a usable image URL for a hotel.
         * - If DB value is a full URL, return it.
         * - If DB value is a storage path, return asset('storage/...')
         * - Otherwise return placeholder.
         */
        if (!function_exists('hotel_image_url')) {
            function hotel_image_url($hotel)
            {
                $img = optional(optional($hotel->hotelImages)->first())->image ?? null;
                if (!$img) {
                    return asset('images/placeholder-hotel.png');
                }
                return preg_match('/^https?:\\/\\//', $img) ? $img : asset('storage/' . ltrim($img, '/'));
            }
        }

        // Ensure variables exist to avoid undefined variable errors in older controllers
        $hotels = $hotels ?? collect();
        $amenities = $amenities ?? collect();
    @endphp

    <div class="container">
        <div class="top-photo">
            <h1>Find Your Perfect Hotel</h1>
        </div>
        <!-- Search Bar -->
        <div class="mb-4">
            <form class="row g-2 align-items-center" method="get" action="{{ url()->current() }}">
                <div class="col-md-3">
                    <input type="text" name="destination" class="form-control" placeholder="Destination (city)"
                        value="{{ request('destination') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" name="checkin" class="form-control" value="{{ request('checkin') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" name="checkout" class="form-control" value="{{ request('checkout') }}">
                </div>

                <div class="col-md-2">
                    <select name="rooms" class="form-select">
                        <option value="1" {{ request('rooms') == 1 ? 'selected' : '' }}>1 Room</option>
                        <option value="2" {{ request('rooms') == 2 ? 'selected' : '' }}>2 Rooms</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="adults" name="adults" class="form-select">
                        <option value="">Select number of guests</option>

                        @foreach ($guestOptions as $g)
                            <option value="{{ $g }}"
                                {{ (string) old('adults', request('adults')) === (string) $g ? 'selected' : '' }}>
                                {{ $g }} {{ $g > 1 ? 'people' : 'person' }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <aside class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-filter me-2"></i>Filters</h6>

                        <form id="filters-form" method="get" action="{{ url()->current() }}">
                            {{-- preserve existing query params --}}
                            <input type="hidden" name="destination" value="{{ request('destination') }}">
                            <input type="hidden" name="checkin" value="{{ request('checkin') }}">
                            <input type="hidden" name="checkout" value="{{ request('checkout') }}">
                            <input type="hidden" name="rooms" value="{{ request('rooms') }}">
                            <input type="hidden" name="adults" value="{{ request('adults') }}">

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

                        {{-- <div class="mb-2">
                            <label class="form-label fw-bold small">Sort by</label>
                            <select class="form-select" name="sort" form="filters-form">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>
                                    Recommended</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low
                                    to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price:
                                    High to Low</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                            </select>
                        </div> --}}
                        <div class="mb-2">
                            <label class="form-label fw-bold small">Sort by</label>
                            <select class="form-select" name="sort" form="filters-form"
                                onchange="document.getElementById('filters-form').submit()">
                                <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>
                                    Recommended
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Price: Low to High
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Price: High to Low
                                </option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                                    Rating
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Hotel Results -->
            <section class="col-md-9">
                @forelse($hotels as $hotel)
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @php
                                    $imgUrl = hotel_image_url($hotel);
                                @endphp
                                <img src="{{ $hotel->image_path }}" alt="{{ $hotel->name }}"
                                    class="img-fluid rounded-start w-100" style="height:220px; object-fit:cover;">
                            </div>

                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title mb-1 fw-bold">{{ $hotel->name }}</h5>
                                            <div class="small text-muted"><i
                                                    class="fa-solid fa-location-dot me-1"></i>{{ $hotel->city ?? $hotel->address }}
                                            </div>
                                            @php
                                                // コントローラで withCount / withAvg を付与している前提
                                                $reviewsCount = $hotel->reviews_count ?? 0;
                                                $avg = $hotel->reviews_avg_rating
                                                    ? number_format($hotel->reviews_avg_rating, 1)
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
                                                $rooms = $hotel->rooms ?? collect();
                                                
                                                if (request('sort') === 'price_desc') {
                                                    $priceRaw = $hotel->max_price ?? ($rooms->count() ? $rooms->max('charges') : null);
                                                } else {
                                                    $priceRaw = $hotel->min_price ?? ($rooms->count() ? $rooms->min('charges') : null);
                                                }

                                                // 表示用にフォーマット（小数点2桁）
                                                $displayPrice =
                                                    $priceRaw !== null
                                                        ? number_format((float) $priceRaw, 2)
                                                        : null;

                                                // コントローラで available_rooms_count を付与しているならそれを使う
                                                // 付与していない場合は null（ビューでは rooms の有無で判断）
                                                $available = $hotel->available_rooms_count ?? null;
                                            @endphp

                                            {{-- 部屋が無い場合は明示的メッセージを出す --}}
                                            @if ($rooms->count() === 0)
                                                <div class="h6 mb-0 text-muted">No rooms</div>
                                                <div class="small text-muted">Room information has not yet been registered.</div>
                                            @else
                                                @if ($available !== null && (int) $available <= 0)
                                                    <div class="h5 mb-0 text-danger">Sold out</div>
                                                    <div class="small text-muted">No available rooms for selected dates</div>
                                                @elseif ($displayPrice !== null)
                                                    <div class="h5 mb-0">₱{{ $displayPrice }}~</div>
                                                    <div class="small text-muted">per night</div>
                                                @else
                                                    <div class="h6 mb-0 text-muted">Price unavailable</div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <p class="card-text text-muted mt-2 mb-2">
                                        {{ \Illuminate\Support\Str::limit($hotel->description, 120) }}</p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.hotels.detail', ['id' => $hotel->id]) }}"
                                            class="btn btn-outline-primary btn-sm">Details</a>
                                        {{-- 即時予約ボタンはいったんコメントアウト --}}
                                        {{-- <a href="{{ route('booking.create', ['hotel' => $hotel->id]) }}" --}}
                                        {{-- <a href=# class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-calendar-check me-1"></i>Book Now</a> --}}

                                        {{-- favorite --}}
                                        <div class="ms-3 d-inline-flex align-items-center gap-2">
                                            @if ($hotel->isFavorited())
                                                <form method="POST"
                                                    action="{{ route('user.favorite.destroy', ['hotel', $hotel->id]) }}"
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
                                                    action="{{ route('user.favorite.store', ['hotel', $hotel->id]) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-favorite btn p-0" type="submit"
                                                        aria-label="Favorite">
                                                        <i class="fa-regular fa-heart align-middle"
                                                            style="font-size:1rem;"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            {{-- 合計いいね数（未ログインでも表示） --}}
                                            <div class="favorites-count small text-muted align-middle"
                                                data-count="{{ $hotel->favorites_count ?? 0 }}">
                                                <span class="d-inline-block align-middle">
                                                    {{ $hotel->favorites_count ?? 0 }}</span>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No hotels found for your search.</div>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-3">
                    @if (method_exists($hotels, 'firstItem'))
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                            <div class="mb-2 mb-sm-0 text-muted">
                                @if ($hotels->total() > 0)
                                    Showing <strong>{{ $hotels->firstItem() }}</strong> to
                                    <strong>{{ $hotels->lastItem() }}</strong> of <strong>{{ $hotels->total() }}</strong>
                                    results
                                @else
                                    No results found
                                @endif
                            </div>

                            <nav aria-label="Search results pages">
                                {{ $hotels->withQueryString()->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    @elseif (method_exists($hotels, 'links'))
                        {{-- links() はあるが件数メソッドがない場合（簡易表示） --}}
                        <nav aria-label="Search results pages">
                            {{ $hotels->withQueryString()->links('pagination::bootstrap-5') }}
                        </nav>
                    @else
                        {{-- フォールバック（静的） --}}
                        <nav aria-label="Search results pages">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="#"
                                        tabindex="-1">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </section>
        </div>
    </div>


    

    <style>
        .top-photo {
            width: 100%;
            height: 200px;
            margin-bottom: 20px;
            background-image: url("{{ asset('images/home-hotel.jpg') }}");
            background-size: cover;
            background-position: center 80%;
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
