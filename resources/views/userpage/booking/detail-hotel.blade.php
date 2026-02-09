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
                            <div class="row body">

                                <div class="hotel-images">
                                    @foreach ($hotel->hotelImages as $image)
                                        <img src="{{ asset('storage/hotels/' . $image->image) }}" alt="hotel image">
                                    @endforeach
                                </div>

                                <p><strong>Description:</strong> {{ $hotel->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hotel list --}}
                <h3 class="fw-bold mb-3">Available room</h3>

                @foreach ($rooms as $room)
                    <div class="col">
                        <div class="card mb-3 shadow-sm" style="overflow: hidden;">
                            <div class="row g-0">

                                <div class="col-md-4 position-static">
                                    <div class="room-images">
                                        @foreach ($room->images as $image)
                                            <img src="{{ asset('storage/rooms/' . $image->image) }}" alt="room image">
                                        @endforeach
                                    </div>

                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2">
                                            {{ $room->type->name ?? 'No Type' }}
                                        </h5>

                                        <ul class="list-unstyled text-secondary small">
                                            <li class="mb-1">Floor: {{ $room->floor_number }}</li>
                                            <li class="mb-1">Max Guests: {{ $room->max_guests }}</li>
                                            <li class="mb-1">Status: {{ $room->status->name ?? 'Unknown' }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-8 border-start position-relative">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold">Room Charge</h6>
                                                <ul class="list-unstyled small mb-0">
                                                    <li>Price depends on room type</li>
                                                </ul>
                                            </div>

                                            <div class="text-end">
                                                <div class="h4 fw-bold mb-0">
                                                    ${{ $room->charges }}
                                                    <small class="text-muted fs-6">per night</small>
                                                </div>

                                                <a href="#" class="btn btn-primary px-4 stretched-link">
                                                    Book Now
                                                </a>
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
