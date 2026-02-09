@extends('layouts.user')

@section('title', 'Detail Restaurant')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">

                {{-- Restaurant Info --}}
                <div class="card bg-white">
                    <div class="card-body">

                        <div class="row header">
                            <div class="col-6">
                                <h1>{{ $restaurant->name }}</h1>
                            </div>

                            <div class="col-6 text-end">
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $restaurant->star_rating)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-star text-secondary"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <div class="col">
                                <p class="restaurant-address">
                                    <strong>
                                        <i class="fa-solid fa-location-dot"></i>
                                        Address
                                    </strong>
                                    {{ $restaurant->address }}
                                </p>
                            </div>
                        </div>

                        <div class="row body">
                            <div class="restaurant-images">
                                @foreach ($restaurant->restaurantImages as $image)
                                    <img src="{{ asset('storage/restaurants/' . $image->image) }}" alt="restaurant image">
                                @endforeach
                            </div>

                            <p>
                                <strong>Description:</strong>
                                {{ $restaurant->description }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Table list --}}
                <h3 class="fw-bold mb-3 mt-4">Available Seats</h3>

                @foreach ($tables as $table)
                    <div class="col">
                        <div class="card mb-3 shadow-sm" style="overflow: hidden;">
                            <div class="row g-0">

                                <!-- left -->
                                <div class="col-md-4">

                                    <div class="table-images">
                                        @foreach ($table->images as $image)
                                            <img src="{{ asset('storage/tables/' . $image->image) }}" alt="table image">
                                        @endforeach
                                    </div>

                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2">
                                            {{ $table->type->name ?? 'No Type' }}
                                        </h5>

                                        <ul class="list-unstyled text-secondary small">
                                            <li class="mb-1">Max Guests: {{ $table->max_guests }}</li>
                                            <li class="mb-1">Status: {{ $table->status->name ?? 'Unknown' }}</li>
                                        </ul>
                                    </div>

                                </div>

                                <!-- right -->
                                <div class="col-md-8 border-start  position-relative">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold">Reservation Info</h6>
                                                <ul class="list-unstyled small mb-0">
                                                    <li>Seats depend on table type</li>
                                                </ul>
                                            </div>

                                            <div class="text-end">
                                               <a href="#"
                                                    class="btn btn-primary px-4 stretched-link">
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
    </div>

@endsection
