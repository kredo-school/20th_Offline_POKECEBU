@extends('layouts.user')

@section('title', 'Detail Hotel')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- 1. Hotel Info Section --}}
            <div class="card bg-white border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <p class="text-muted mb-0">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    {{ $hotel->address }}
                                </p>
                                
                                {{-- Star Rating --}}
                                @php
                                    $rating = $hotel->star_rating;
                                    $fullStars = floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5;
                                @endphp
                                <div class="text-warning">
                                    @for ($i = 1; $i <= $fullStars; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    @endif
                                    <span class="text-muted ms-1 fw-bold">{{ number_format($rating, 1) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Favorite Button --}}
                        <div class="ms-3">
                            @if ($hotel->isFavorited())
                                <form method="POST" action="{{ route('user.favorite.destroy', ['hotel', $hotel->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn favorite-btn border-0 bg-transparent">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.favorite.store', ['hotel', $hotel->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn favorite-btn border-0 bg-transparent">
                                        <i class="fa-regular fa-heart text-secondary"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Hotel Gallery --}}
                    <div class="hotel-images mb-4 hide-scrollbar" style="display: flex; overflow-x: auto; gap: 15px;">
                        @foreach ($hotel->hotelImages as $image)
                            <img src="{{ asset('storage/' . $image->image) }}" alt="hotel image" class="rounded-3" style="height: 250px; object-fit: cover;">
                        @endforeach
                    </div>

                    <div class="border-top pt-4">
                        <h5 class="fw-bold mb-3">About this hotel</h5>
                        <p class="text-secondary lh-lg mb-0">
                            {{ $hotel->description }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. Room List Section --}}
            <div class="d-flex align-items-center mb-4 px-2">
                <div class="bg-primary rounded-pill me-3" style="width: 5px; height: 30px;"></div>
                <h3 class="fw-bold mb-0">Available Rooms</h3>
            </div>

            @foreach ($rooms as $room)
                @php $isAvailable = $room->status->name == 'Available'; @endphp
                
                <div class="card room-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden {{ !$isAvailable ? 'opacity-75' : '' }}">
                    <div class="row g-0">
                        {{-- Left: Room Images --}}
                        <div class="col-md-5 bg-light position-relative border-end">
                            <div class="room-images hide-scrollbar" style="{{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}">
                                @foreach ($room->images as $image)
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="room image">
                                @endforeach
                            </div>

                            @if (!$isAvailable)
                                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center" style="z-index: 5;">
                                    <span class="badge bg-dark px-4 py-2 fs-6 shadow">Fully Booked</span>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <h5 class="fw-bold mb-2 {{ !$isAvailable ? 'text-muted' : 'text-dark' }}">
                                    {{ $room->type->name }}
                                </h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                        <i class="fa-solid fa-layer-group me-1 text-primary"></i> Floor: {{ $room->floor_number }}
                                    </span>
                                    <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                        <i class="fa-solid fa-user-group me-1 text-primary"></i> Max: {{ $room->max_guests }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Room Details --}}
                        <div class="col-md-7 bg-white">
                            <div class="card-body p-4 h-100 d-flex flex-column" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-uppercase text-muted fw-bold ls-1">Room Description</small>
                                    </div>
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        {{ Str::limit($room->detail, 160) ?? 'Click to see full photos, amenities, and room details.' }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-end">
                                    <div>
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.7rem;">Price per night</small>
                                        <div class="h2 fw-bold {{ !$isAvailable ? 'text-muted' : 'text-primary' }} mb-0">
                                            ₱{{ number_format($room->charges) }}
                                        </div>
                                    </div>
                                    <div>
                                        @if ($isAvailable)
                                            <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                                Show Details
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-lg px-5 rounded-pill disabled border-0">Unavailable</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Room Detail Modal --}}
                <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Room Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-4 mb-md-0">
                                        <div class="room-gallery hide-scrollbar" style="display: flex; overflow-x: auto; gap: 10px;">
                                            @foreach ($room->images as $image)
                                                <img src="{{ asset('storage/' . $image->image) }}" class="rounded-3" alt="Room Image" style="width: 100%; height: 300px; object-fit: cover; flex-shrink: 0;">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h3 class="fw-bold mb-1">{{ $room->type->name }}</h3>
                                                <p class="text-muted small mb-0">Room No. {{ $room->room_number }}</p>
                                            </div>
                                            <span class="badge {{ $isAvailable ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                                {{ $room->status->name }}
                                            </span>
                                        </div>
                                        
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Room Information</h6>
                                        <div class="bg-light p-3 rounded-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                            <p class="text-dark small mb-0" style="white-space: pre-wrap; line-height: 1.7;">{{ $room->detail }}</p>
                                        </div>

                                        <div class="row text-center g-2 mt-auto">
                                            <div class="col-6">
                                                <div class="bg-light py-2 rounded-2">
                                                    <small class="text-muted d-block small">Floor / Guests</small>
                                                    <span class="fw-bold text-dark">Lvl {{ $room->floor_number }} / {{ $room->max_guests }}P</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light py-2 rounded-2 border border-primary border-opacity-25">
                                                    <small class="text-muted d-block small">Nightly Rate</small>
                                                    <span class="fw-bold text-primary">₱{{ number_format($room->charges) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4 pt-0">
                                <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Close</button>
                                @if ($isAvailable)
                                    <form method="GET" action="{{ route('user.hotels.show', ['hotel' => $hotel->id]) }}">
                                        <input type="hidden" name="clear_reservation_session" value="1">
                                        <input type="hidden" name="guests" value="{{ request('guests', 1) }}">
                                        <input type="hidden" name="checkin" value="{{ request('checkin') }}">
                                        <input type="hidden" name="checkout" value="{{ request('checkout') }}">
                                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow">Confirm & Reserve Now</button>
                                    </form>
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