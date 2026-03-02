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
                            @if ($restaurant->isFavorited())
                                <form method="POST" action="{{ route('user.favorite.destroy', ['restaurant', $restaurant->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn favorite-btn border-0 bg-transparent">
                                        <i class="fa-solid fa-heart text-danger"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }}">
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
                            <img src="{{ asset('storage/restaurants/' . $image->image) }}" alt="restaurant image">
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
                
                <div class="card table-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden {{ !$isAvailable ? 'opacity-75' : '' }}">
                    <div class="row g-0">
                        {{-- Left: Table Images --}}
                        <div class="col-md-5 bg-light position-relative border-end">
                            <div class="table-images hide-scrollbar" style="{{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}">
                                @foreach ($table->images as $image)
                                    <img src="{{ asset('storage/tables/' . $image->image) }}" alt="table image">
                                @endforeach
                            </div>

                            @if (!$isAvailable)
                                <div class="position-absolute top-50 start-50 translate-middle w-100 text-center" style="z-index: 5;">
                                    <span class="badge bg-dark px-4 py-2 fs-6 shadow">Fully Booked</span>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <h5 class="fw-bold mb-2 {{ !$isAvailable ? 'text-muted' : 'text-dark' }}">
                                    {{ $table->type->name ?? 'Standard Table' }}
                                </h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                        <i class="fa-solid fa-chair me-1"></i> {{ $table->type->name }}
                                    </span>
                                    <span class="badge bg-light text-secondary border-0 fw-normal py-2 px-3">
                                        <i class="fa-solid fa-user-group me-1"></i> Max: {{ $table->max_guests }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Table Details --}}
                        <div class="col-md-7 bg-white">
                            <div class="card-body p-4 h-100 d-flex flex-column" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#tableModal{{ $table->id }}">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-uppercase text-muted fw-bold ls-1">Seating Description</small>
                                        <span class="text-primary small fw-bold"><i class="fa-solid fa-maximize"></i> Details</span>
                                    </div>
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        {{ Str::limit($table->detail, 160) ?? 'Click to see full photos, table location, and seating details.' }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-end">
                                    <div>
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 0.7rem;">Reservation Fee</small>
                                        <div class="h2 fw-bold {{ !$isAvailable ? 'text-muted' : 'text-primary' }} mb-0">
                                            {{ isset($table->charges) && $table->charges > 0 ? '$' . number_format($table->charges) : 'Free' }}
                                        </div>
                                    </div>
                                    <div>
                                        @if ($isAvailable)
                                            <a href="#" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                                Book Now
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-lg px-5 rounded-pill disabled border-0">Unavailable</button>
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
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Table Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-4 mb-md-0">
                                        <div class="table-images hide-scrollbar">
                                            @foreach ($table->images as $image)
                                                <img src="{{ asset('storage/tables/' . $image->image) }}" class="w-100 rounded-3" alt="Table Image" style="height: 300px;">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h3 class="fw-bold mb-1">{{ $table->type->name }}</h3>
                                                <p class="text-muted small mb-0">Table No. {{ $table->table_number ?? 'N/A' }}</p>
                                            </div>
                                            <span class="badge {{ $isAvailable ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                                {{ $table->status->name }}
                                            </span>
                                        </div>
                                        
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Detailed Information</h6>
                                        <div class="bg-light p-3 rounded-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                            <p class="text-dark small mb-0" style="white-space: pre-wrap; line-height: 1.7;">{{ $table->detail }}</p>
                                        </div>

                                        <div class="row text-center g-2 mt-auto">
                                            <div class="col-6">
                                                <div class="bg-light py-2 rounded-2">
                                                    <small class="text-muted d-block small">Capacity</small>
                                                    <span class="fw-bold text-dark">{{ $table->max_guests }} Persons</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light py-2 rounded-2 border border-primary border-opacity-25">
                                                    <small class="text-muted d-block small">Booking Fee</small>
                                                    <span class="fw-bold text-primary">{{ $table->charges > 0 ? '$' . number_format($table->charges) : 'Free' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4 pt-0">
                                <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold" data-bs-dismiss="modal">Close</button>
                                @if ($isAvailable)
                                    <a href="#" class="btn btn-primary rounded-pill px-5 fw-bold shadow">Confirm & Book Now</a>
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