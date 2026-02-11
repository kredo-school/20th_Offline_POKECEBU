@extends('layouts.user')

@section('title', 'Detail Hotel')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- Hotel Info --}}
                <div class="card bg-white border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="fw-bold mb-1">{{ $hotel->name }}</h1>
                                <p class="text-muted mb-0">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    {{ $hotel->address }}
                                </p>
                            </div>
                            <div class="star-rating text-nowrap">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $hotel->star_rating)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-secondary opacity-25"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <div class="hotel-images mb-4 hide-scrollbar">
                            @foreach ($hotel->hotelImages as $image)
                                <img src="{{ asset('storage/hotels/' . $image->image) }}" alt="hotel image">
                            @endforeach
                        </div>

                        <div>
                            <h5 class="fw-bold">About this hotel</h5>
                            <p class="text-secondary lh-lg mb-0">
                                {{ $hotel->description }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Room list --}}
                <h3 class="fw-bold mb-4">Available Rooms</h3>

                @foreach ($rooms as $room)
                    {{-- ルームカード --}}
                    <div
                        class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden {{ $room->status->name != 'Available' ? 'opacity-75' : '' }}">
                        <div class="row g-0">
                            {{-- 左側：画像エリア（クリック不可） --}}
                            <div class="col-md-5 bg-light position-relative border-end">
                                <div class="room-images hide-scrollbar"
                                    style="{{ $room->status->name != 'Available' ? 'filter: grayscale(100%);' : '' }}">
                                    @foreach ($room->images as $image)
                                        <img src="{{ asset('storage/rooms/' . $image->image) }}" alt="room image">
                                    @endforeach
                                </div>

                                {{-- 予約不可時のラベル --}}
                                @if ($room->status->name != 'Available')
                                    <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 5;">
                                        <span class="badge bg-dark px-3 py-2 opacity-75 fs-6">Sold Out</span>
                                    </div>
                                @endif

                                <div class="p-3">
                                    <h5
                                        class="fw-bold mb-2 {{ $room->status->name != 'Available' ? 'text-muted' : 'text-dark' }}">
                                        {{ $room->type->name ?? 'Standard Room' }}
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-white text-secondary border fw-normal">
                                            <i class="fa-solid fa-stairs me-1"></i> Floor: {{ $room->floor_number }}
                                        </span>
                                        <span class="badge bg-white text-secondary border fw-normal">
                                            <i class="fa-solid fa-user me-1"></i> Max: {{ $room->max_guests }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- 右側：詳細エリア（ここをクリックするとモーダルが開く） --}}
                            <div class="col-md-7 bg-white" style="cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#roomModal{{ $room->id }}">

                                <div class="card-body p-4 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-uppercase text-muted fw-bold ls-1 d-block mb-2">Room
                                                Description</small>
                                            <span class="text-primary small fw-bold"><i class="fa-solid fa-maximize"></i>
                                                View Details</span>
                                        </div>
                                        <p class="text-secondary small mb-4" style="line-height: 1.6;">
                                            {{ Str::limit($room->detail, 160) ?? 'Click to see full amenities, gallery, and room rules.' }}
                                        </p>
                                    </div>

                                    <div class="row align-items-center mt-auto">
                                        <div class="col-lg-6 mb-3 mb-lg-0">
                                            <small class="text-uppercase text-muted fw-bold ls-1">Price per night</small>
                                            <div
                                                class="h2 fw-bold {{ $room->status->name != 'Available' ? 'text-muted' : 'text-primary' }} mb-0">
                                                ${{ number_format($room->charges) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-lg-end">
                                            @if ($room->status->name == 'Available')
                                                <a href="#"
                                                    class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold position-relative"
                                                    style="z-index: 1050;">
                                                    Book Now
                                                </a>
                                            @else
                                                <button
                                                    class="btn btn-secondary btn-lg px-5 rounded-pill disabled shadow-none">
                                                    Unavailable
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ルーム詳細モーダル --}}
                    <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 overflow-hidden">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Room Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        {{-- モーダル内左：スライダー --}}
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <div id="roomCarousel{{ $room->id }}" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="room-images hide-scrollbar">
                                                    @foreach ($room->images as $image)
                                                        <img src="{{ asset('storage/rooms/' . $image->image) }}"
                                                            alt="Room Image">
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#roomCarousel{{ $room->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#roomCarousel{{ $room->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- モーダル内右：詳細 --}}
                                        <div class="col-md-6 d-flex flex-column">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h3 class="fw-bold mb-0">{{ $room->type->name }}</h3>
                                                    <span
                                                        class="badge {{ $room->status->name == 'Available' ? 'bg-success' : 'bg-danger' }} px-3">
                                                        {{ $room->status->name }}
                                                    </span>
                                                </div>
                                                <p class="text-muted small">Room No. {{ $room->room_number ?? 'N/A' }}</p>
                                            </div>

                                            <div class="flex-grow-1 overflow-auto" style="max-height: 200px;">
                                                <h6 class="text-uppercase text-muted small fw-bold ls-1">Description</h6>
                                                <p class="text-dark small" style="white-space: pre-wrap; line-height: 1.7;">
                                                    {{ $room->detail }}</p>
                                            </div>

                                            <div class="mt-auto pt-3">
                                                <div class="p-3 bg-light rounded-3">
                                                    <div class="row g-0 text-center">
                                                        <div class="col-4 border-end">
                                                            <small class="text-muted d-block small">Floor</small>
                                                            <span class="fw-bold">{{ $room->floor_number }}</span>
                                                        </div>
                                                        <div class="col-4 border-end">
                                                            <small class="text-muted d-block small">Capacity</small>
                                                            <span class="fw-bold">{{ $room->max_guests }}</span>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block small">Price</small>
                                                            <span
                                                                class="fw-bold text-primary">${{ number_format($room->charges) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Close</button>
                                    @if ($room->status->name == 'Available')
                                        <a href="#" class="btn btn-primary rounded-pill px-5 fw-bold shadow">Confirm
                                            Reservation</a>
                                    @else
                                        <button class="btn btn-secondary rounded-pill px-5 disabled">Fully Booked</button>
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
