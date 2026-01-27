{{-- resources/views/userpage/mypage/hotel-search-result.blade.php --}}
@extends('layouts.user')

@section('content')

@php
  /**
   * Development helper: provide dummy data when $hotels or $amenities
   * are not supplied by a controller. Remove this block when wiring
   * up a real controller.
   */
  if (!isset($hotels)) {
      $hotels = collect([
          (object)[
              'id' => 1,
              'name' => 'Sample Hotel Cebu',
              'description' => 'Comfortable stay near the city center with great service and clean rooms.',
              'address' => '123 Mango Ave',
              'city' => 'Cebu City',
              'latitude' => 10.3157,
              'longitude' => 123.8854,
              'star_rating' => 4.5,
              'phone' => '+63 32 123 4567',
              'website' => 'https://example-hotel.local',
              'hotelImages' => collect([(object)['image' => 'placeholder-hotel.png']]),
              'rooms' => collect([
                  (object)['id' => 101, 'charges' => 2500, 'max_guests' => 2, 'status_id' => 1],
                  (object)['id' => 102, 'charges' => 3000, 'max_guests' => 3, 'status_id' => 1],
              ]),
              'reviews' => collect([
                  (object)['rating' => 5, 'comment' => 'Excellent!'],
                  (object)['rating' => 4, 'comment' => 'Very good location.'],
              ]),
              'categories' => collect([(object)['id' => 1, 'name' => 'Free Wi-Fi']]),
          ],
          (object)[
              'id' => 2,
              'name' => 'Oceanview Inn',
              'description' => 'Small boutique hotel with ocean views and friendly staff.',
              'address' => '45 Beach Rd',
              'city' => 'Mactan',
              'latitude' => 10.3070,
              'longitude' => 123.9940,
              'star_rating' => 4.0,
              'phone' => '+63 32 987 6543',
              'website' => 'https://oceanview.local',
              'hotelImages' => collect([(object)['image' => 'placeholder-hotel-2.png']]),
              'rooms' => collect([
                  (object)['id' => 201, 'charges' => 3200, 'max_guests' => 2, 'status_id' => 1],
              ]),
              'reviews' => collect([]),
              'categories' => collect([(object)['id' => 2, 'name' => 'Swimming Pool']]),
          ],
      ]);
  }

  if (!isset($amenities)) {
      $amenities = collect([
          (object)['id' => 1, 'name' => 'Free Wi-Fi'],
          (object)['id' => 2, 'name' => 'Swimming Pool'],
          (object)['id' => 3, 'name' => 'Breakfast Included'],
          (object)['id' => 4, 'name' => 'Parking'],
      ]);
  }
@endphp

<div class="container py-4">
  <!-- Search Bar -->
  <div class="mb-4">
    <form class="row g-2 align-items-center" method="get" action="#">
      <div class="col-md-3">
        <input type="text" name="destination" class="form-control" placeholder="Destination (city)" value="{{ request('destination') }}">
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

          <form id="filters-form" method="get" action="#">
            {{-- preserve existing query params --}}
            <input type="hidden" name="destination" value="{{ request('destination') }}">
            <input type="hidden" name="checkin" value="{{ request('checkin') }}">
            <input type="hidden" name="checkout" value="{{ request('checkout') }}">
            <input type="hidden" name="rooms" value="{{ request('rooms') }}">
            <input type="hidden" name="adults" value="{{ request('adults') }}">

            @foreach($amenities as $amenity)
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="amenity-{{ $amenity->id }}" name="amenities[]" value="{{ $amenity->id }}"
                  {{ in_array($amenity->id, (array)request('amenities', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="amenity-{{ $amenity->id }}">{{ $amenity->name }}</label>
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
              <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
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
                $img = optional($hotel->hotelImages->first())->image ?? null;
                $imgUrl = $img ? asset('storage/' . $img) : asset('images/placeholder-hotel.png');
              @endphp
              <img src="{{ $imgUrl }}" alt="{{ $hotel->name }}" class="img-fluid rounded-start w-100" style="height:220px; object-fit:cover;">
            </div>

            <div class="col-md-8">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="card-title mb-1 fw-bold">{{ $hotel->name }}</h5>
                    <div class="small text-muted"><i class="fa-solid fa-location-dot me-1"></i>{{ $hotel->city ?? $hotel->address }}</div>
                    @if(!empty($hotel->star_rating))
                      <div class="small text-warning mt-1">★ {{ number_format($hotel->star_rating, 1) }}</div>
                    @endif
                  </div>

                  <div class="text-end">
                    @php
                      $avg = $hotel->reviews->count() ? number_format($hotel->reviews->avg('rating'), 1) : null;
                      $minPrice = $hotel->rooms->count() ? number_format($hotel->rooms->min('charges')) : null;
                    @endphp

                    @if($avg)
                      <div class="badge bg-success mb-2"><i class="fa-solid fa-star me-1"></i>{{ $avg }}</div>
                    @else
                      <div class="badge bg-secondary mb-2">No reviews</div>
                    @endif

                    @if($minPrice)
                      <div class="h5 mb-0">₱{{ $minPrice }}</div>
                      <div class="small text-muted">per night</div>
                    @else
                      <div class="h6 mb-0 text-muted">No rooms</div>
                    @endif
                  </div>
                </div>

                <p class="card-text text-muted mt-2 mb-2">{{ \Illuminate\Support\Str::limit($hotel->description, 120) }}</p>

                <div class="d-flex gap-2">
                  <a href="#" class="btn btn-outline-secondary btn-sm">Details</a>
                  <a href="#" class="btn btn-primary btn-sm"><i class="fa-solid fa-calendar-check me-1"></i>Book Now</a>

                  {{-- Favorite toggle (dummy form for UI) --}}
                  <form action="#" method="post" class="d-inline">
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

      {{-- Pagination (dummy links when using dummy collection) --}}
      <div class="mt-3">
        @if(method_exists($hotels, 'links'))
          {{ $hotels->withQueryString()->links() }}
        @else
          <nav aria-label="Search results pages">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>
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