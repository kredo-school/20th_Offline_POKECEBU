@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css/mypage/booking.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6FA9DE; height:80px;">
    <div class="container">
        <span class="navbar-brand fw-bold">My Account</span>
    </div>
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">

        {{-- 左メニュー --}}
        <div class="col-3 d-flex flex-column mb-4">
            <a href="{{ route('mypage') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Profile</a>
            <a href="{{ route('booking') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1 active">My Booking</a>
            <a href="{{ route('favorite') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">

                    {{-- タブ --}}
                    <ul class="nav nav-tabs nav-justified mb-3">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#hotel">
                                Hotel Reservations
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#restaurant">
                                Restaurant Reservations
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        {{-- =========================
                            HOTEL
                        ========================== --}}
                        <div class="tab-pane fade show active" id="hotel">

                            {{-- Upcoming --}}
                            <h5 class="mb-3">Upcoming</h5>
                            @forelse($upcomingHotels as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Hotel:</strong> {{ $res->hotel->name ?? 'N/A' }}</p>
                                    <p><strong>Guests:</strong> {{ $res->guests }}</p>
                                    <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($res->start_at)->format('Y-m-d H:i') }}</p>
                                    <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($res->end_at)->format('Y-m-d H:i') }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-success">Active</span>
                                </div>
                            @empty
                                <p>No upcoming hotel reservations.</p>
                            @endforelse

                            {{-- Past --}}
                            <h5 class="mt-4 mb-3">Past</h5>
                            @forelse($pastHotels as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm bg-light">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Hotel:</strong> {{ $res->hotel->name ?? 'N/A' }}</p>
                                    <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($res->start_at)->format('Y-m-d H:i') }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-secondary">Completed</span>
                                </div>
                            @empty
                                <p>No past hotel reservations.</p>
                            @endforelse

                            {{-- Cancelled --}}
                            <h5 class="mt-4 mb-3">Cancelled</h5>
                            @forelse($cancelledHotels as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm bg-light">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Hotel:</strong> {{ $res->hotel->name ?? 'N/A' }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-danger">Cancelled</span>
                                </div>
                            @empty
                                <p>No cancelled hotel reservations.</p>
                            @endforelse
                        </div>


                        {{-- =========================
                            RESTAURANT
                        ========================== --}}
                        <div class="tab-pane fade" id="restaurant">

                            {{-- Upcoming --}}
                            <h5 class="mb-3">Upcoming</h5>
                            @forelse($upcomingRestaurants as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Restaurant:</strong> {{ $res->restaurant->name ?? 'N/A' }}</p>
                                    <p><strong>Guests:</strong> {{ $res->guests }}</p>
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($res->start_at)->format('Y-m-d H:i') }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-success">Active</span>
                                </div>
                            @empty
                                <p>No upcoming restaurant reservations.</p>
                            @endforelse

                            {{-- Past --}}
                            <h5 class="mt-4 mb-3">Past</h5>
                            @forelse($pastRestaurants as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm bg-light">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Restaurant:</strong> {{ $res->restaurant->name ?? 'N/A' }}</p>
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($res->start_at)->format('Y-m-d H:i') }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-secondary">Completed</span>
                                </div>
                            @empty
                                <p>No past restaurant reservations.</p>
                            @endforelse

                            {{-- Cancelled --}}
                            <h5 class="mt-4 mb-3">Cancelled</h5>
                            @forelse($cancelledRestaurants as $res)
                                <div class="border rounded p-3 mb-3 shadow-sm bg-light">
                                    <p><strong>Reservation ID:</strong> {{ $res->reservation_id }}</p>
                                    <p><strong>Restaurant:</strong> {{ $res->restaurant->name ?? 'N/A' }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($res->total_price,2) }}</p>
                                    <span class="badge bg-danger">Cancelled</span>
                                </div>
                            @empty
                                <p>No cancelled restaurant reservations.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
