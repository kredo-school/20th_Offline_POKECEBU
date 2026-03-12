@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main-style.css') }}">
@endpush

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h2 class="fw-bold text-center mb-5">Payment</h2>

    <div class="res-card text-center mb-4">
        <label class="label-en">Total Amount</label>
        <h1 class="fw-bold text-primary display-4">¥{{ number_format($totalPrice) }}</h1>
    </div>

    <div class="res-card">
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

            <button type="submit" class="btn btn-success btn-round w-100 py-3 shadow mt-2 text-white">
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