@extends('layouts.user')

@push('styles')
    {{-- main_style.css を優先して適用 --}}
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main_style.css') }}">
    {{-- hotel-details用の微調整が必要な場合のみ読み込み（空でも可） --}}
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/hotel-details.css') }}">
    <style>
        /* ふわっと表示されるアニメーション */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.15s; }
        .delay-2 { animation-delay: 0.3s; }

        /* 画像やカードを触ったときに動くアニメーション */
        .hover-move {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-move:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
        }
        .hover-move:active {
            transform: scale(0.97);
        }

        /* ボタン用のアニメーション */
        .btn-hover-move {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-hover-move:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(13, 110, 253, 0.3) !important;
        }
        .btn-hover-move:active {
            transform: scale(0.95);
        }
    </style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 text-center">

            <h1 class="fw-bold mb-2 display-4 animate-fade-in">{{ $hotel->name }}</h1>
            <p class="text-muted mb-5 animate-fade-in">
                <i class="fa-solid fa-location-dot me-2 text-primary"></i>{{ $hotel->address ?? 'Cebu, Philippines' }}
            </p>

            <div class="hotel-gallery mb-5 animate-fade-in delay-1">
                @if ($hotel->images->count())
                    <div class="row g-3">
                        @foreach ($hotel->images as $index => $image)
                            <div class="{{ $loop->first ? 'col-12' : 'col-md-6' }}">
                                <img src="{{ $image->image }}" class="img-fluid rounded-4 shadow-sm w-100 hover-move" 
                                     style="{{ $loop->first ? 'height: 450px;' : 'height: 250px;' }} object-fit: cover; cursor: pointer;">
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{ $hotel->image_path ?? asset('images/default-hotel.jpg') }}" 
                         class="img-fluid rounded-4 shadow-sm w-100 hover-move" style="height: 400px; object-fit: cover; cursor: pointer;">
                @endif
            </div>

            <hr class="my-5 opacity-10">

            <div class="mb-5 animate-fade-in delay-2">
                <h2 class="fw-bold mb-2">Available Rooms</h2>
                <p class="text-muted small text-uppercase fw-bold">Please select your stay dates and room type</p>
            </div>

            <div class="row g-4 justify-content-center animate-fade-in delay-2">
                @foreach ($hotel->roomTypes as $roomType)
                    <div class="col-md-10 col-lg-8">
                        <div class="res-card text-start shadow-sm hover-move">
                            
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
                                        <button type="submit" class="btn btn-primary btn-round w-100 py-3 shadow btn-hover-move">
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