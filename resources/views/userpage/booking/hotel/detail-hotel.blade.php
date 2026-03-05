@extends('layouts.user')

@section('title', 'Detail Hotel')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- 1. Hotel Main Info --}}
            <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <p class="text-muted mb-0">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    {{ $hotel->address }}
                                </p>
                                {{-- Star Rating --}}
                                @php
                                    $rating = $hotel->star_rating;
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
                                </div>
                            </div>
                        </div>

                        {{-- Favorite Button --}}
                        <div class="ms-3">
                            @if ($hotel->isFavorited())
                                <form method="POST" action="{{ route('user.favorite.destroy', ['hotel', $hotel->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-favorite border-0 bg-transparent p-0">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.favorite.store', ['hotel', $hotel->id]) }}">
                                    @csrf
                                    <button class="btn btn-favorite border-0 bg-transparent p-0">
                                        <i class="fa-regular fa-heart text-secondary"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Hotel Image Gallery --}}
                    <div class="hotel-images mb-4 hide-scrollbar">
                        @foreach ($hotel->hotelImages as $image)
                            <img src="{{ asset('storage/hotels/' . $image->image) }}" alt="hotel image">
                        @endforeach
                    </div>

                    <div class="border-top pt-4">
                        <h5 class="fw-bold mb-3">About this hotel</h5>
                        <p class="text-secondary lh-lg mb-0">{{ $hotel->description }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. Room List Section --}}
            <div class="d-flex align-items-center mb-4 px-2">
                <div class="bg-primary rounded-pill me-3" style="width: 5px; height: 30px;"></div>
                <h3 class="fw-bold mb-0">Available Table</h3>
            </div>

            @foreach ($rooms as $room)
                @php $isAvailable = $room->status->name == 'Available'; @endphp
                <div class="card room-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden {{ !$isAvailable ? 'opacity-75' : '' }}">
                    <div class="row g-0">
                        {{-- Room Images (Left) --}}
                        <div class="col-md-5 bg-light position-relative border-end">
                            <div class="room-images hide-scrollbar" style="{{ !$isAvailable ? 'filter: grayscale(80%);' : '' }}">
                                @foreach ($room->images as $image)
                                    <img src="{{ asset('storage/rooms/' . $image->image) }}" alt="room image">
                                @endforeach
                            </div>

                            @if (!$isAvailable)
                                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center" style="z-index: 5;">
                                    <span class="badge bg-dark px-4 py-2 fs-6 shadow-sm">Sold Out</span>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <h5 class="fw-bold mb-2">{{ $room->type->name ?? 'Standard Room' }}</h5>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                        <i class="fa-solid fa-stairs me-1 text-primary"></i> Floor {{ $room->floor_number }}
                                    </span>
                                    <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                        <i class="fa-solid fa-user me-1 text-primary"></i> Max {{ $room->max_guests }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Room Details (Right) --}}
                        <div class="col-md-7 d-flex flex-column" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
                            <div class="card-body p-4 d-flex flex-column h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-uppercase text-muted fw-bold">Room Description</small>
                                    <span class="text-primary small fw-bold"><i class="fa-solid fa-maximize"></i> Details</span>
                                </div>
                                <p class="text-secondary small flex-grow-1" style="line-height: 1.6;">
                                    {{ Str::limit($room->detail, 180) ?? 'Click to see full amenities, gallery, and room rules.' }}
                                </p>

                                <div class="row align-items-center mt-3 border-top pt-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Price per night</small>
                                        <span class="h3 fw-bold {{ $isAvailable ? 'text-primary' : 'text-muted' }} mb-0">
                                            ₱{{ number_format($room->charges) }}
                                        </span>
                                    </div>
                                    <div class="col-6 text-end">
                                        @if ($isAvailable)
                                            <a href="#" class="btn btn-primary btn-lg px-4 rounded-pill fw-bold shadow-sm">
                                                Book Now
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-lg px-4 rounded-pill disabled shadow-none">Unavailable</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Section (省略せず構造維持) --}}
                <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Room Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="room-images hide-scrollbar">
                                            @foreach ($room->images as $image)
                                                <img src="{{ asset('storage/rooms/' . $image->image) }}" class="w-100 rounded-3" alt="Room Image" style="height: 300px; object-fit: cover;">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h3 class="fw-bold mb-0">{{ $room->type->name }}</h3>
                                            <span class="badge {{ $isAvailable ? 'bg-success' : 'bg-danger' }} px-3">{{ $room->status->name }}</span>
                                        </div>
                                        <p class="text-muted small">Room No. {{ $room->room_number ?? 'N/A' }}</p>
                                        <h6 class="text-uppercase text-muted small fw-bold mt-4">Description</h6>
                                        <p class="text-dark small lh-lg">{{ $room->detail }}</p>
                                        
                                        <div class="mt-4 p-3 bg-light rounded-3 text-center row g-0">
                                            <div class="col-4 border-end">
                                                <small class="text-muted d-block">Floor</small>
                                                <span class="fw-bold">{{ $room->floor_number }}</span>
                                            </div>
                                            <div class="col-4 border-end">
                                                <small class="text-muted d-block">Max</small>
                                                <span class="fw-bold">{{ $room->max_guests }}</span>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted d-block">Price</small>
                                                <span class="fw-bold text-primary">₱{{ number_format($room->charges) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4 pt-0">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                @if ($isAvailable)
                                    <a href="#" class="btn btn-primary rounded-pill px-5 fw-bold shadow">Reserve Now</a>
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