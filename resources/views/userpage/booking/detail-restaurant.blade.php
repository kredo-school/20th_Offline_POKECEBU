@extends('layouts.user')

@section('title', 'Detail Restaurant')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- Restaurant Info --}}
                <div class="card bg-white border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="fw-bold mb-1">{{ $restaurant->name }}</h1>
                                <p class="text-muted mb-0">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i>
                                    {{ $restaurant->address }}
                                </p>
                            </div>
                            <div class="star-rating text-nowrap">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $restaurant->star_rating)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-secondary opacity-25"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <div class="restaurant-images mb-4 hide-scrollbar">
                            @foreach ($restaurant->restaurantImages as $image)
                                <img src="{{ asset('storage/restaurants/' . $image->image) }}" alt="restaurant image">
                            @endforeach
                        </div>

                        <div>
                            <h5 class="fw-bold">About this restaurant</h5>
                            <p class="text-secondary lh-lg mb-0">
                                {{ $restaurant->description }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Table list --}}
                <h3 class="fw-bold mb-4">Available Seats</h3>

                @foreach ($tables as $table)
                    @if ($table->status->name == 'Available')
                        <div class="card mb-4 border-0 shadow-sm rounded-4 table-card overflow-hidden">
                            <div class="row g-0">

                                {{-- Left: Image & Details --}}
                                <div class="col-md-5 position-static bg-light">
                                    <div class="table-images hide-scrollbar">
                                        @foreach ($table->images as $image)
                                            <img src="{{ asset('storage/tables/' . $image->image) }}" alt="table image">
                                        @endforeach
                                    </div>

                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2 text-dark">
                                            {{ $table->type->name ?? 'Standard Seat' }}
                                        </h5>

                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                <i class="fa-solid fa-chair me-1"></i> Type:
                                                {{ $table->type->name ?? 'N/A' }}
                                            </span>
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                <i class="fa-solid fa-user-group me-1"></i> Max: {{ $table->max_guests }}
                                            </span>
                                            <span class="badge bg-white text-secondary border fw-normal">
                                                Status: {{ $table->status->name ?? 'Unknown' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Reservation & Action --}}
                                <div class="col-md-7 position-relative d-flex align-items-center">
                                    <div class="card-body p-4 w-100">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 mb-3 mb-lg-0">
                                                <small class="text-uppercase text-muted fw-bold ls-1">Reservation
                                                    Fee</small>

                                                {{-- もし charges カラムがあれば表示、なければ Free --}}
                                                @if (isset($table->charges) && $table->charges > 0)
                                                    <div class="h2 fw-bold text-primary mb-0">
                                                        ${{ number_format($table->charges) }}
                                                    </div>
                                                    <p class="small text-muted mb-0 mt-1">
                                                        per booking
                                                    </p>
                                                @else
                                                    <div class="h2 fw-bold text-primary mb-0">
                                                        Free
                                                    </div>
                                                    <p class="small text-muted mb-0 mt-1">
                                                        Reservation required
                                                    </p>
                                                @endif
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
