@extends('layouts.user')

@push('styles')
    {{-- main_style.css を優先して適用 --}}
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main_style.css') }}">
    {{-- hotel-details用の微調整が必要な場合のみ読み込み（空でも可） --}}
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/hotel-details.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 text-center">

            <h1 class="fw-bold mb-2 display-4">{{ $hotel->name }}</h1>
            <p class="text-muted mb-5">
                <i class="fa-solid fa-location-dot me-2 text-primary"></i>{{ $hotel->address ?? 'Cebu, Philippines' }}
            </p>

            <div class="hotel-gallery mb-5">
                @if ($hotel->images->count())
                    <div class="row g-3">
                        @foreach ($hotel->images as $index => $image)
                            <div class="{{ $loop->first ? 'col-12' : 'col-md-6' }}">
                                <img src="{{ $image->image }}" class="img-fluid rounded-4 shadow-sm w-100" 
                                     style="{{ $loop->first ? 'height: 450px;' : 'height: 250px;' }} object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{ $hotel->image_path ?? asset('images/default-hotel.jpg') }}" 
                         class="img-fluid rounded-4 shadow-sm w-100" style="height: 400px; object-fit: cover;">
                @endif
            </div>

            <hr class="my-5 opacity-10">

            <div class="mb-5">
                <h2 class="fw-bold mb-2">Available Rooms</h2>
                <p class="text-muted small text-uppercase fw-bold">Please select your stay dates and room type</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($hotel->roomTypes as $roomType)
                    <div class="col-md-10 col-lg-8">
                        <div class="res-card text-start shadow-sm">
                            
                            <div class="d-md-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold mb-0">
                                    {{ ucfirst($roomType->roomType->name) }} Room
                                </h3>
                                <div class="badge bg-light text-primary rounded-pill px-3 py-2 mt-2 mt-md-0">
                                    <span class="small fw-bold">{{ $roomType->total_rooms }} Rooms Left</span>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('user.mypage.show') }}">
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="label-en">Check-in</label>
                                        <input type="date" name="checkin" class="field-input"
                                            value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="label-en">Check-out</label>
                                        <input type="date" name="checkout" class="field-input"
                                            value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="label-en">Guests</label>
                                        <select name="guests" class="field-input">
                                            @for ($i = 1; $i <= 4; $i++)
                                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'People' : 'Person' }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary btn-round w-100 py-3 shadow">
                                            Book This Room <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection