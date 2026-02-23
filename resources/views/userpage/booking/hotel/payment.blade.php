

@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 600px; margin:auto;">
    <h2 class="fw-bold mb-4 text-center">Payment</h2>

    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h4 class="mb-2">{{ $hotel->name ?? 'No hotel information' }}</h4>
        <p>Room: {{ optional($roomType->roomType)->name ?? 'No room information' }}</p>
        <p>Guests: {{ $guests ?? '1' }}</p>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fs-5">Total Amount:</span>
            <span class="fs-3 fw-bold text-primary">¥{{ number_format($totalPrice ?? 0) }}</span>
        </div>
    </div>

    <!-- ダミー決済フォーム -->
 
    <form id="payment-form" method="POST" action="{{ route('reservation.confirm') }}">
        @csrf
        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
        <input type="hidden" name="guests" value="{{ $guests }}">

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="guest_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="guest_email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="guest_phone" class="form-control">
        </div>

        <hr>
        <h5>Card Information (Test Only)</h5>
        <div class="mb-3">
            <label>Card Number</label>
            <input type="text" name="card_number" class="form-control" placeholder="1111 2222 3333 4444" required>
        </div>
        <div class="mb-3">
            <label>Expiry</label>
            <input type="text" name="expiry" class="form-control" placeholder="MM/YY" required>
        </div>
        <div class="mb-3">
            <label>CVV</label>
            <input type="text" name="cvv" class="form-control" placeholder="123" required>
        </div>

        <button type="submit" class="btn btn-success w-100">
            Pay Now
        </button>
    </form>

    <!-- スピナー -->
    <div id="spinner" style="display:none; text-align:center; margin-top:20px;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Processing...</span>
        </div>
        <p>Processing payment...</p>
    </div>

</div>

<script>
document.getElementById('payment-form').addEventListener('submit', function(e){
    // 1. 二重送信を防ぐためにボタンを無効化
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;

    // 2. フォームを隠してスピナーを表示
    this.style.display = 'none';
    document.getElementById('spinner').style.display = 'block';

    // 3. e.preventDefault() を消す（または実行しない）ことで、
    // そのまま Controller の confirmReservation へデータが飛びます。
});
</script>
@endsection
