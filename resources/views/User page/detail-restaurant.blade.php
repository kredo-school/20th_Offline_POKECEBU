@extends('layouts.app')
 
@section('title', 'detail restaurant')
 
@section('content')

{{-- Restaurant Info --}}
<div class="card mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">
            <h1 class="fw-bold">{{ $restaurant->name }}</h1>

            {{-- Rating --}}
            <div class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $restaurant->rating)
                        <i class="fa-solid fa-star text-warning"></i>
                    @else
                        <i class="fa-regular fa-star text-secondary"></i>
                    @endif
                @endfor
            </div>
        </div>

        <p class="text-muted mt-2 restaurant-address">
            <i class="fa-solid fa-location-dot"></i>
            {{ $restaurant->address }}
        </p>

        <div class="restaurant-images my-3">
            <img src="{{ asset('images/pokecebuicon.png') }}">
            <img src="{{ asset('images/pokecebuname.png') }}">
            <img src="{{ asset('images/hotel3.jpg') }}">
        </div>

        <p>
            <strong>Description:</strong><br>
            {{ $restaurant->description }}
        </p>
    </div>
</div>

{{-- テーブルの種類だけループ --}}
{{-- Table list --}}
<h3 class="fw-bold mb-3">Available Seats</h3>

<div class="row">
    @forelse ($tables as $table)
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">

                <div class="card-body d-flex flex-column">
                    <h5 class="fw-bold">
                        Table #{{ $table->table_number }}
                    </h5>

                    <ul class="list-unstyled text-muted small mb-3">
                        <li>Capacity: {{ $table->capacity }} people</li>
                        <li>Location: {{ ucfirst($table->location) }}</li>
                    </ul>

                    <div class="mt-auto">
                        @if ($table->is_available)
                            <a href="{{ route('tables.reserve', $table->id) }}"
                               class="btn btn-primary w-100">
                                Reserve
                            </a>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                Unavailable
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @empty
        <p class="text-muted">No tables available.</p>
    @endforelse
</div>
    
@endsection
 