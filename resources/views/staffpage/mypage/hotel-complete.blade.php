@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card text-center">
        {{-- Success Icon & Message --}}
        <div class="ig-success-header mb-5">
            <div class="ig-success-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2 class="ig-card-title mt-3">Application Submitted!</h2>
            <p class="ig-card-subtitle">Your hotel information is now under review by our team.</p>
        </div>

        {{-- Application Summary Preview --}}
        <div class="ig-summary-box text-start mb-5">
            <h4 class="ig-summary-title">Application Summary</h4>
            <div class="ig-summary-content">
                <div class="ig-summary-item">
                    <span class="label">Hotel Name</span>
                    <span class="value">{{ $tmpHotel->name }}</span>
                </div>
                <div class="ig-summary-item">
                    <span class="label">Representative</span>
                    <span class="value">{{ $tmpHotel->representative_name }}</span>
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
            We will notify you via <strong>{{ $tmpHotel->representative_email }}</strong> once the review is complete.
        </p>

        {{-- Action Button --}}
        <div class="ig-form-footer" style="justify-content: center; border: none;">
            <a href="{{ route('hotel.mypage.hotel') }}" class="ig-btn-primary" style="width: 200px; text-decoration: none; text-align: center;">
                Back to My Page
            </a>
        </div>
    </div>
</div>
@endsection