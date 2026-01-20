@extends('layouts.user')

@section('title', 'Detail Hotel')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="row header">
                            <div class="col-6">
                                <h1>{{ $hotel->name }}</h1>
                            </div>
                            <div class="col-6 text-end">
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->star_rating)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-star text-secondary"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="col">
                                <p class="hotel-address"><strong><i class="fa-solid fa-location-dot"></i>Address</strong>
                                    {{ $hotel->address }}</p>
                            </div>
                        </div>
                        <div class="row body">
                            <div class="hotel-images">
                                <img src="{{ asset('images/pokecebuicon.png') }}">
                                <img src="{{ asset('images/pokecebuname.png') }}">
                                <img src="{{ asset('images/hotel3.jpg') }}">
                            </div>
                            <p><strong>Description:</strong> {{ $hotel->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

                {{-- Hotel list --}}
                    <h3 class="fw-bold mb-3">Available room</h3>

            {{-- roomのでループさせる⬇️ --}}
            @foreach ($rooms as $room)
                <div class="col">
                    <div class="card mb-3 shadow-sm" style="max-width: 1000px; overflow: hidden;">
                        <div class="row g-0">

                            <!-- left: info -->
                            <div class="col-md-4">
                                <div class="room-images">
                                    @foreach ($room->images as $image)
                                        <img src="{{ asset('storage/' . $image->path) }}">
                                    @endforeach
                                </div>

                                <div class="p-3">
                                    <h5 class="fw-bold mb-3">{{ $room->name }}</h5>

                                    <ul class="list-unstyled text-secondary small">
                                        <li class="mb-1">{{ $room->bed_type }}</li>
                                        <li class="mb-1">{{ $room->size }} m²</li>
                                        <li class="mb-1">{{ $room->view_type }}</li>
                                    </ul>

                                    <a href="{{ route('rooms.show', $room->id) }}"
                                        class="text-primary small text-decoration-none fw-bold">
                                        Room Details
                                    </a>
                                </div>
                            </div>

                            <!-- right: price -->
                            <div class="col-md-8 border-start">
                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold">{{ $room->plan_name }}</h6>
                                            <ul class="list-unstyled small mb-0">
                                                <li>Breakfast included</li>
                                            </ul>
                                        </div>

                                        <div class="text-end">
                                            <div class="h4 fw-bold mb-0">
                                                ${{ $room->price }}
                                                <small class="text-muted fs-6">per night</small>
                                            </div>
                                            <button class="btn btn-primary px-4">
                                                Book Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
