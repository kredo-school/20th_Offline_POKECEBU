@extends('layouts.user')

@section('title', 'Detail Restaurant')

@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- 1. Restaurant Info Section --}}
                <div class="card bg-white border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h1 class="fw-bold mb-2">{{ $restaurant->name }}</h1>
                                <div class="d-flex align-items-center flex-wrap gap-3">
                                    <p class="text-muted mb-0">
                                        <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                        {{ $restaurant->address }}
                                    </p>

                                    {{-- Star Rating --}}
                                    @php
                                        $rating = $restaurant->star_rating;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                    @endphp
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= $fullStars; $i++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor
                                        @if ($halfStar)
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        @endif
                                        <span class="text-muted ms-1 fw-bold">{{ number_format($rating, 1) }}</span>
                                        <a href="{{ route('user.restaurant.reviews', $restaurant->id) }}"
                                            class="text-primary text-decoration-none small fw-bold">
                                            Read all reviews <i class="fa-solid fa-chevron-right small"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Favorite Button --}}
                            <div class="ms-3">
                                @if ($restaurant->isFavorited())
                                    <form method="POST"
                                        action="{{ route('user.favorite.destroy', ['restaurant', $restaurant->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn favorite-btn border-0 bg-transparent">
                                            <i class="fa-solid fa-heart text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                        action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn favorite-btn border-0 bg-transparent">
                                            <i class="fa-regular fa-heart text-secondary"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Restaurant Gallery --}}
                        <div class="restaurant-images mb-4 hide-scrollbar">
                            @foreach ($restaurant->restaurantImages as $image)
                                <img src="{{ $image->image }}" alt="restaurant image">
                            @endforeach
                        </div>

                        <div class="border-top pt-4">
                            <h5 class="fw-bold mb-3">About this restaurant</h5>
                            <p class="text-secondary lh-lg mb-0">
                                {{ $restaurant->description }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 2. Table List Section --}}
                <div class="d-flex align-items-center mb-4 px-2">
                    <div class="bg-primary rounded-pill me-3" style="width: 5px; height: 30px;"></div>
                    <h3 class="fw-bold mb-0">Available Seats</h3>
                </div>

                @foreach ($tables as $table)
                    @php $isAvailable = $table->status->name == 'Available'; @endphp

                    <div
                        class="card table-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden {{ !$isAvailable ? 'opacity-75' : '' }}">
                        <div class="row g-0">
                            {{-- Left: Table Images --}}
                            <div class="col-md-5 bg-light position-relative border-end">
                                <div class="table-images hide-scrollbar"
                                    style="{{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}">
                                    @foreach ($table->images as $image)
                                        <img src="{{ $image->image }}" alt="table image">
                                    @endforeach
                                </div>

                                @if (!$isAvailable)
                                    <div class="position-absolute top-50 start-50 translate-middle w-100 text-center"
                                        style="z-index: 5;">
                                        <span class="badge bg-dark px-4 py-2 fs-6 shadow">Fully Booked</span>
                                    </div>
                                @endif

                                <div class="p-3 bg-white">
                                    <h5 class="fw-bold mb-2 {{ !$isAvailable ? 'text-muted' : 'text-dark' }}">
                                        {{ $table->type->name ?? 'Standard Table' }}
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                            <i class="fa-solid fa-chair me-1 text-primary"></i> {{ $table->type->name }}
                                        </span>
                                        <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                            <i class="fa-solid fa-user-group me-1 text-primary"></i> Max:
                                            {{ $table->max_guests }}
                                        </span>
                                        @foreach ($table->categories as $category)
                                            <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Right: Table Details --}}
                            <div class="col-md-7 bg-white">
                                <div class="card-body p-4 h-100 d-flex flex-column" style="cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#tableModal{{ $table->id }}">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-uppercase text-muted fw-bold ls-1">Seating
                                                Description</small>
                                        </div>
                                        <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                            {{ Str::limit($table->detail, 160) ?? 'Click to see full photos, table location, and seating details.' }}
                                        </p>
                                    </div>

                                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-end">
                                        <div>
                                            <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                                style="font-size: 0.7rem;">Reservation Fee</small>
                                            <div
                                                class="h2 fw-bold {{ !$isAvailable ? 'text-muted' : 'text-primary' }} mb-0">
                                                {{ isset($table->charges) && $table->charges > 0 ? '₱' . number_format($table->charges) : 'Free' }}
                                            </div>
                                        </div>
                                        <div>
                                            @if ($isAvailable)
                                                <button type="button"
                                                    class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                                    Show Details
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-secondary btn-lg px-5 rounded-pill disabled border-0">Unavailable</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Table Detail Modal --}}
                    <div class="modal fade" id="tableModal{{ $table->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-dark">Table Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-4">
                                    <div class="row">
                                        {{-- Left Side: Images & Amenities --}}
                                        <div class="col-md-6 mb-4 mb-md-0 d-flex flex-column">
                                            {{-- Image Gallery (Scroll Snap) --}}
                                            <div class="table-images hide-scrollbar mb-3"
                                                style="display: flex; overflow-x: auto; gap: 10px; scroll-snap-type: x mandatory;">
                                                @foreach ($table->images as $image)
                                                    <img src="{{ $image->image }}" class="rounded-3 shadow-sm"
                                                        alt="Table Image"
                                                        style="width: 100%; height: 280px; object-fit: cover; flex-shrink: 0; scroll-snap-align: start;">
                                                @endforeach
                                            </div>

                                            {{-- Amenities Section --}}
                                            <div class="amenities-wrapper">
                                                <h6 class="text-uppercase text-muted small fw-bold mb-3 ls-1">
                                                    <i class="fa-solid fa-utensils me-1 text-primary"></i> Features
                                                </h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @forelse ($table->categories as $category)
                                                        <span
                                                            class="badge bg-light text-secondary border-0 fw-normal py-2 px-3 rounded-pill">
                                                            {{ $category->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted small">Standard dining features.</span>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Right Side: Info & Pricing --}}
                                        <div class="col-md-6 d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h3 class="fw-bold mb-1 text-dark">{{ $table->type->name }}</h3>
                                                </div>
                                                <span
                                                    class="badge {{ $isAvailable ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill shadow-sm">
                                                    {{ $isAvailable ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </div>

                                            <h6 class="text-uppercase text-muted small fw-bold mb-2 ls-1">Detailed
                                                Information</h6>
                                            <div class="bg-light p-3 rounded-4 mb-4 flex-grow-1"
                                                style="max-height: 220px; overflow-y: auto; border: 1px solid #edf2f7;">
                                                <p class="text-dark small mb-0"
                                                    style="white-space: pre-wrap; line-height: 1.8;">{{ $table->detail }}
                                                </p>
                                            </div>

                                            {{-- Specs & Price Grid --}}
                                            <div class="row text-center g-2 mt-auto">
                                                <div class="col-6">
                                                    <div class="bg-light py-3 rounded-3 border-0">
                                                        <small class="text-muted d-block small mb-1">Capacity</small>
                                                        <span class="fw-bold text-dark"><i
                                                                class="fa-solid fa-user-group me-1 small"></i>
                                                            {{ $table->max_guests }} Persons</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div
                                                        class="bg-primary bg-opacity-10 py-3 rounded-3 border border-primary border-opacity-25">
                                                        <small class="text-primary d-block small mb-1 fw-bold">Booking
                                                            Fee</small>
                                                        <span class="fw-bold text-primary fs-5">
                                                            {{ $table->charges > 0 ? '₱' . number_format($table->charges) : 'Free' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer: Actions --}}
                                <div class="modal-footer border-0 p-4 pt-0 justify-content-between">
                                    <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold"
                                        data-bs-dismiss="modal">Close</button>

                                    @if ($isAvailable)
                                        <a href="{{ route('user.restaurant.show', ['restaurant' => $restaurant->id]) }}"
                                            class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow">
                                            Confirm & Book Now <i class="fa-solid fa-chevron-right ms-2 small"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
