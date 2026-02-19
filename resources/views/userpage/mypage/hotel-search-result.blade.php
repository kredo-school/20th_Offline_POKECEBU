{{-- resources/views/userpage/mypage/hotel-search-result.blade.php --}}
@extends('layouts.user')

@section('content')
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

    <div class="container py-4">
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
                    <select name="adults" class="form-select">
                        <option value="2" {{ request('adults') == 2 ? 'selected' : '' }}>2 Adults</option>
                        <option value="1" {{ request('adults') == 1 ? 'selected' : '' }}>1 Adult</option>
                    </select>
                </div>

                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
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

                        <hr>

                        <div class="mb-2">
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
                                <img src="{{ $imgUrl }}" alt="{{ $hotel->name }}"
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
                                            @if (!empty($hotel->star_rating))
                                                <div class="small text-warning mt-1">★
                                                    {{ number_format($hotel->star_rating, 1) }}</div>
                                            @endif
                                        </div>

                                        <div class="text-end">
                                            @php
                                                $reviews = $hotel->reviews ?? collect();
                                                $avg = $reviews->count()
                                                    ? number_format($reviews->avg('rating'), 1)
                                                    : null;
                                                $rooms = $hotel->rooms ?? collect();
                                                $minPrice = $rooms->count()
                                                    ? number_format($rooms->min('charges'))
                                                    : null;
                                            @endphp

                                            @if ($avg)
                                                <div class="badge bg-success mb-2"><i
                                                        class="fa-solid fa-star me-1"></i>{{ $avg }}</div>
                                            @else
                                                <div class="badge bg-secondary mb-2">No reviews</div>
                                            @endif

                                            {{-- 部屋が無い場合は明示的メッセージを出す --}}
                                            @if ($rooms->count() === 0)
                                                <div class="h6 mb-0 text-muted">No rooms</div>
                                                <div class="small text-muted">部屋情報がまだ登録されていません。</div>
                                            @else
                                                {{-- 部屋がある場合は最安値を表示 --}}
                                                <div class="h5 mb-0">₱{{ $minPrice }}</div>
                                                <div class="small text-muted">per night</div>
                                            @endif


                                            {{-- 
                                            @if ($minPrice)
                                                <div class="h5 mb-0">₱{{ $minPrice }}</div>
                                                <div class="small text-muted">per night</div>
                                            @else
                                                <div class="h6 mb-0 text-muted">No rooms</div>
                                            @endif --}}
                                        </div>
                                    </div>

                                    <p class="card-text text-muted mt-2 mb-2">
                                        {{ \Illuminate\Support\Str::limit($hotel->description, 120) }}</p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.hotels.detail', ['id' => $hotel->id]) }}"
                                            class="btn btn-outline-secondary btn-sm">Details</a>
                                        {{-- <a href=# class="btn btn-outline-secondary btn-sm">Details</a> --}}
                                        {{-- <a href="{{ route('booking.create', ['hotel' => $hotel->id]) }}" --}}
                                        {{-- <a href=# class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-calendar-check me-1"></i>Book Now</a> --}}

                                        {{-- Favorite toggle (replace route with your actual endpoint) --}}
                                        {{-- <form action="{{ route('favorites.toggle') }}" method="post" class="d-inline"> --}}
                                        <form action=# method="post" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="target_type" value="hotel">
                                            <input type="hidden" name="target_id" value="{{ $hotel->id }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">❤</button>
                                        </form>
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
                    @if (method_exists($hotels, 'links'))
                        {{ $hotels->withQueryString()->links() }}
                    @else
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
@endsection
