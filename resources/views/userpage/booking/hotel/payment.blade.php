@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 600px; margin:auto;">
    <h2 class="fw-bold mb-4 text-center">Payment</h2>

    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h4 class="mb-2">{{ $hotel->name ?? 'No hotel information' }}</h4>
        <p>Room: {{ optional($roomType->roomType)->name ?? 'No room information' }}</p>
        <p>Guests: {{ $guests ?? '1' }}</p>
<div class="container my-5">
    <h2 class="text-center mb-4">Payment</h2>
    
    <div class="card p-4 shadow-sm">
        <h4>Reservation Summary</h4>
        <hr>
        <p><strong>Hotel:</strong> {{ $hotel->name }}</p>
        <p><strong>Room:</strong> {{ $roomType->roomType->name ?? 'N/A' }}</p>
        <p><strong>Guests:</strong> {{ $guests }}</p>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fs-5">Total Amount:</span>
            <span class="fs-3 fw-bold text-primary">¥{{ number_format($totalPrice) }}</span>
        </div>
    </div>
    
    </div>    </div>

    <form id="reservation-form">
        @csrf
        <input type="hidden" id="hotel_id" value="{{ $hotel->id }}">
        <input type="hidden" id="room_type_id" value="{{ $roomType->id }}">
        <input type="hidden" id="guests" value="{{ $guests }}">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" id="guest_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" id="guest_email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" id="guest_phone" class="form-control">
        </div>

        <h5 class="mt-4 mb-3">Card Information</h5>
        <div class="mb-3">
            <label class="form-label">Card Number</label>
            <input type="text" id="card_number" class="form-control" placeholder="1234 5678 9012 3456" required>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Expiry Date</label>
                <input type="text" id="card_expiry" class="form-control" placeholder="MM/YY" required>
            </div>
            <div class="col mb-3">
                <label class="form-label">CVC</label>
                <input type="text" id="card_cvc" class="form-control" placeholder="123" required>
            </div>
        </div>

        <div id="dummy-card-container" class="text-center mt-4">
            <button type="button" onclick="handleFakeCardPayment()" class="btn w-100 mb-2" 
                    style="background-color: #28a745; border-radius: 4px; height: 45px; border: none; font-weight: bold; font-style: italic; font-size: 1.2rem; color: white;">
                Pay Now
            </button>
        </div>
    </form>
</div>

<script>
function handleFakeCardPayment() {
    // Basic input validation
    const name = document.getElementById('guest_name').value;
    const email = document.getElementById('guest_email').value;
    const cardNumber = document.getElementById('card_number').value;
    const expiry = document.getElementById('card_expiry').value;
    const cvc = document.getElementById('card_cvc').value;

    if (!name || !email || !cardNumber || !expiry || !cvc) {
        alert('Please fill in all required fields including card information.');
        return;
    }

    // Show loading spinner
    const container = document.getElementById('dummy-card-container');
    container.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p>Processing payment...</p>';

    // Simulate payment delay
    setTimeout(() => {
        // Redirect to success page
        window.location.href = "{{ route('reservation.success') }}";
    }, 1500);
}
</script>
@endsection
