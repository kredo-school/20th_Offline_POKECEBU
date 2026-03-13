@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main_style.css') }}">
@endpush

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="res-card text-center shadow-lg" style="max-width: 500px; width: 100%;">
        
        <div class="mb-4">
            <div class="display-1 text-primary">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <h2 class="fw-bold mb-3">Reservation Completed!</h2>
        <div style="width: 40px; height: 4px; background: #0d6efd; margin: 15px auto; border-radius: 10px;"></div>

        <p class="text-muted mb-4 px-3">
            Thank you for choosing us.<br>
            Your reservation has been successfully processed.<br>
            <span class="small opacity-75">*(The payment process is for testing purposes only.)</span>
        </p>

        <div class="mt-5">
            <a href="{{ route('user.mypage') }}" class="btn btn-primary btn-round w-100 shadow">
                Back to My Page
            </a>
        </div>

        <div class="mt-3">
            <a href="/" class="btn btn-link text-decoration-none text-muted small">
                Back to Home
            </a>
        </div>
        
    </div>
</div>
@endsection