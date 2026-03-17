@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main-style.css') }}">
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
        .res-card:active {
            transform: scale(0.98);
        }
        .btn-animated {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(25, 135, 84, 0.3) !important; /* success modifier */
        }
        .btn-animated:active {
            transform: scale(0.95);
            box-shadow: 0 4px 8px rgba(25, 135, 84, 0.2) !important;
        }
    </style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h2 class="fw-bold text-center mb-5 animate-fade-in-up">Payment</h2>

    <div class="res-card text-center mb-4 animate-fade-in-up delay-1">
        <label class="label-en">Total Amount</label>
        <h1 class="fw-bold text-primary display-4 mt-2">₱{{ number_format($totalPrice) }}</h1>
    </div>

    <div class="res-card animate-fade-in-up delay-2">
        <form id="payment-form" method="POST" action="{{ route('user.reservation.pay') }}">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
            <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
            <input type="hidden" name="guests" value="{{ $guests }}">
            <input type="hidden" name="start_at" value="{{ session('checkin') }}">
    <input type="hidden" name="end_at" value="{{ session('checkout') }}">

            <div class="mb-4">
                <label class="label-en">Cardholder Name</label>
                <input type="text" name="guest_name" class="field-input" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="mb-4">
                <label class="label-en">Card Number</label>
                <input type="text" name="card_number" class="field-input" placeholder="0000 0000 0000 0000" required>
            </div>

            <button type="submit" class="btn btn-success btn-round w-100 py-3 shadow mt-3 text-white btn-animated fs-5 fw-bold">
                Pay Now
            </button>
        </form>

        <div id="spinner" style="display:none; text-align:center; margin-top:2rem;">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 label-en text-center">Processing...</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        // 二重送信を防ぐために、一度だけ実行されるようにする
        const btn = this.querySelector('button[type="submit"]');
        if (btn.disabled) return; 

        btn.disabled = true; // ボタンを無効化
        document.getElementById('spinner').style.display = 'block'; // スピナー表示
        this.style.opacity = '0.5'; // フォームを半透明に
    });
</script>
@endsection