@extends('layouts.staff')

@push('styles')
    {{-- ホテル版と共通のCSSを使用 --}}
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-hotel.css') }}">
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card">
        {{-- Header --}}
        <div class="ig-card-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="ig-card-title">Restaurant Profile</h2>
                <p class="ig-card-subtitle">Public information of your restaurant</p>
            </div>
            <a href="{{ route('staff.edit.restaurant') }}" class="ig-btn-primary">
                Edit / Apply Changes
            </a>
        </div>

        {{-- Restaurant Visual Section --}}
        <div class="ig-profile-header mb-5">
            <div class="ig-avatar-container">
                <img src="{{ $restaurant && $restaurant->image_path ? asset('storage/' . $restaurant->image_path) : 'https://via.placeholder.com/150' }}"
                     alt="Restaurant Image" class="ig-hotel-img">
            </div>
            <div class="ig-hotel-info">
                <h3 class="ig-hotel-name">{{ $restaurant->name ?? 'Sample Restaurant' }}</h3>
                <div class="ig-rating">
                    {{-- もし星評価がある場合はここにループを入れる --}}
                    <span class="badge bg-light text-dark border">{{ $restaurant->city ?? 'Location not set' }}</span>
                </div>
                <p class="ig-hotel-desc">{{ $restaurant->description ?? 'No description provided.' }}</p>
            </div>
        </div>

        {{-- Information Grid --}}
        <div class="ig-info-grid">
            <div class="ig-info-item">
                <span class="ig-info-label">Representative</span>
                <span class="ig-info-value">{{ $restaurant->representative_name ?? 'Not set' }}</span>
            </div>
            <div class="ig-info-item">
                <span class="ig-info-label">Email</span>
                <span class="ig-info-value">{{ $restaurant->email ?? 'Not set' }}</span>
            </div>
            <div class="ig-info-item">
                <span class="ig-info-label">Phone</span>
                <span class="ig-info-value">{{ $restaurant->phone ?? 'Not set' }}</span>
            </div>
            <div class="ig-info-item">
                <span class="ig-info-label">Website</span>
                <span class="ig-info-value">
                    @if($restaurant && $restaurant->website)
                        <a href="{{ $restaurant->website }}" target="_blank" class="ig-link">{{ $restaurant->website }}</a>
                    @else
                        Not set
                    @endif
                </span>
            </div>
            
            {{-- Location --}}
            <div class="ig-info-item full-width">
                <span class="ig-info-label">Address</span>
                <span class="ig-info-value">{{ $restaurant->address ?? 'Not set' }}</span>
            </div>

            {{-- Coordinates (Small labels for tech info) --}}
            <div class="ig-info-item">
                <span class="ig-info-label">Latitude</span>
                <span class="ig-info-value text-muted" style="font-size: 13px;">{{ $restaurant->latitude ?? '-' }}</span>
            </div>
            <div class="ig-info-item">
                <span class="ig-info-label">Longitude</span>
                <span class="ig-info-value text-muted" style="font-size: 13px;">{{ $restaurant->longitude ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsectione