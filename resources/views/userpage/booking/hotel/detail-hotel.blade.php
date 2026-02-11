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
                    @if ($room->status->name == 'Available')
                        <div class="card mb-4 border-0 shadow-sm rounded-4 room-card overflow-hidden">
                            <div class="row g-0">

                                <div class="col-md-5 bg-light">
                                    <div class="room-images hide-scrollbar">
                                        @foreach ($room->images as $image)
                                            <img src="{{ asset('storage/rooms/' . $image->image) }}" alt="room image">
                                        @endforeach
                                    </div>

                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2 text-dark">
                                            {{ $room->type->name ?? 'Standard Room' }}
                                        </h5>

                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                <i class="fa-solid fa-stairs me-1"></i> Floor: {{ $room->floor_number }}
                                            </span>
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                <i class="fa-solid fa-user me-1"></i> Max: {{ $room->max_guests }}
                                            </span>
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                Status: {{ $room->status->name ?? 'Unknown' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7 position-relative d-flex align-items-center">
                                    <div class="card-body p-4 w-100">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 mb-3 mb-lg-0">
                                                <small class="text-uppercase text-muted fw-bold ls-1">Price</small>
                                                <div class="h2 fw-bold text-primary mb-0">
                                                    ${{ number_format($room->charges) }}
                                                    <small class="text-muted fs-6 fw-normal">/ night</small>
                                                </div>
                                                <p class="small text-muted mb-0 mt-1">
                                                    Includes taxes & fees
                                                </p>
                                            </div>

                                            <div class="col-lg-6 text-lg-end">
                                                <a href="#"
                                                    class="btn btn-primary btn-lg px-5 rounded-pill stretched-link shadow-sm">
                                                    Book Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

@endsection
