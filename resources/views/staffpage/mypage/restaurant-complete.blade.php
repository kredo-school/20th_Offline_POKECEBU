@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card text-center">
        {{-- Success Header --}}
        <div class="ig-success-header mb-5">
            <div class="ig-success-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <h2 class="ig-card-title mt-3">Restaurant Application Submitted!</h2>
            <p class="ig-card-subtitle">Your restaurant information is now under review.</p>
        </div>

        {{-- Application Summary Preview --}}
        <div class="ig-summary-box text-start mb-5">
            <h4 class="ig-summary-title">Application Summary</h4>
            <div class="ig-summary-content">
                <div class="ig-summary-item">
                    <span class="label">Restaurant Name</span>
                    <span class="value">{{ $tmpRestaurant?->name ?? 'N/A' }}</span>
                </div>
                <div class="ig-summary-item">
                    <span class="label">Representative</span>
                    <span class="value">{{ $tmpRestaurant?->representative_name ?? 'N/A' }}</span>
                </div>
                <div class="ig-summary-item">
                    <span class="label">Status</span>
                    <span class="value status-pending">
                        <i class="fa-solid fa-clock"></i> Pending Review
                    </span>
                </div>
            </div>
        </div>

        <p class="text-muted mb-4" style="font-size: 14px;">
            We will notify you via <strong>{{ $tmpRestaurant?->representative_email ?? 'your email' }}</strong> once the review is complete.
        </p>

        {{-- Action Button --}}
        <div class="ig-form-footer" style="justify-content: center; border: none;">
            <a href="{{ route('staff.mypage.restaurant') }}" class="ig-btn-primary" style="width: 200px; text-decoration: none; text-align: center;">
                Back to My Page
            </a>
        </div>
    </div>
</div>
@endsection