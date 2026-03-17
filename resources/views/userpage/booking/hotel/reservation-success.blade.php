@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main_style.css') }}">
    <style>
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
        
        .res-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .res-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
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
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="res-card text-center shadow-lg animate-fade-in-up" style="max-width: 500px; width: 100%;">
        
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

        <div class="mt-5 animate-fade-in-up delay-1">
            <a href="{{ route('user.mypage') }}" class="btn btn-primary btn-round w-100 shadow btn-animated">
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