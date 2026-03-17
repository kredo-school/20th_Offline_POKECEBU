@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main-style.css') }}">
    <style>
        /* 確認画面専用の微調整 */
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px dashed #eee; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #888; font-size: 0.9rem; font-weight: 500; }
        .info-value { font-weight: 700; color: #333; }
        .total-price-box { background: #f8f9ff; border-radius: 20px; padding: 20px; border: 1px solid #eef0ff; }

        /* プレミアムUI用のアニメーションとホバーエフェクト */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        
        .res-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .res-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
        }
        .res-card:active {
            transform: scale(0.98);
        }
        .btn-animated {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3) !important;
        }
        .btn-animated:active {
            transform: scale(0.95);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2) !important;
        }
    </style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 750px;">
    
    <div class="text-center mb-5 animate-fade-in-up">
        <h2 class="fw-bold">Confirm Your Reservation</h2>
        <p class="text-muted small text-uppercase letter-spacing-1">Please review your booking details below</p>
    </div>

    <div class="res-card animate-fade-in-up delay-1">
        <div class="row g-4 align-items-center">
            <div class="col-md-5">
                <img src="{{ $hotel->images->first()->image ?? asset('images/default.jpg') }}" 
                     class="img-fluid rounded-4 shadow-sm w-100" style="height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-7">
                <label class="label-en">Accommodation</label>
                <h3 class="fw-bold mb-1">{{ $hotel->name }}</h3>
                <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i>{{ $hotel->address }}</p>
                
                <div class="total-price-box mt-3 d-flex justify-content-between align-items-center">
                    <span class="label-en mb-0">Total Amount</span>
                    <span class="fs-2 fw-bold text-primary">¥{{ number_format($price * $guestsCount) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="res-card animate-fade-in-up delay-2">
        <h5 class="fw-bold mb-4"><i class="fa-solid fa-calendar-check me-2 text-primary"></i>Stay Details</h5>
        
        <div class="info-row">
            <span class="info-label">Room Type</span>
            <span class="info-value">{{ $roomType->roomType->name ?? 'Standard' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Guests</span>
            <span class="info-value">{{ $guestsCount }} {{ $guestsCount > 1 ? 'People' : 'Person' }}</span>
        </div>
        {{-- もしコントローラーから日程を渡しているなら、ここに追加するとバランスが良くなります --}}
        {{-- <div class="info-row">
            <span class="info-label">Check-in</span>
            <span class="info-value">2026-03-12</span>
        </div> --}}
    </div>

    <div class="res-card animate-fade-in-up delay-3">
        <h5 class="fw-bold mb-4"><i class="fa-solid fa-id-card me-2 text-primary"></i>Guest Details</h5>
        
        <div class="p-3 bg-light rounded-4 mb-4">
            <label class="label-en">Main Guest</label>
            <p class="fw-bold fs-5 mb-1">{{ $userDetail->first_name }} {{ $userDetail->last_name }}</p>
            <p class="text-muted small mb-0">{{ $userDetail->phone }}</p>
        </div>

        @if (!empty($otherGuests))
            <label class="label-en mb-2">Additional Guests</label>
            <div class="row g-2">
                @foreach ($otherGuests as $guest)
                    <div class="col-md-6">
                        <div class="p-3 border rounded-4 small">
                            <div class="fw-bold">{{ $guest['name'] }}</div>
                            <div class="text-muted mt-1">{{ $guest['phone'] ?? 'No phone' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('user.reservation.payment.form') }}">
        @csrf
        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
        <input type="hidden" name="guests" value="{{ $guestsCount }}">
        
        <div class="d-flex gap-3 mt-4 animate-fade-in-up delay-3">
            <a href="{{ route('user.mypage.show') }}" class="btn btn-outline-secondary btn-round px-4 py-3 btn-animated">
                <i class="fa-solid fa-chevron-left me-2"></i>Back
            </a>
            <button type="submit" class="btn btn-primary btn-round flex-grow-1 text-white shadow py-3 btn-animated">
                Proceed to Payment <i class="fa-solid fa-chevron-right ms-2"></i>
            </button>
        </div>
    </form>
</div>
@endsection