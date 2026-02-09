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
            <a href="{{ route('booking') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">My Booking</a>
            <a href="{{ route('favorite') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">
            <div class="card mb-4 w-100">
                <div class="card-body">
                    {{-- 予約タイプ選択 --}}
                    <div class="mb-3">
                        <div class="btn-group w-100" role="group" aria-label="Reservation Type">
                            <input type="radio" class="btn-check" name="reservationType" id="all" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="all">All ✓</label>

                            <input type="radio" class="btn-check" name="reservationType" id="hotel" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hotel">Hotel</label>

                            <input type="radio" class="btn-check" name="reservationType" id="restaurant" autocomplete="off">
                            <label class="btn btn-outline-primary" for="restaurant">Restaurant</label>
                        </div>
                    </div>

                    {{-- タブボタン --}}
                    <ul class="nav nav-tabs nav-justified mb-3" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab"
                                data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming"
                                aria-selected="true">Upcoming Reservation 今の予約</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past"
                                type="button" role="tab" aria-controls="past" aria-selected="false">Past Reservation 過去の予約</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled"
                                type="button" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled Reservation キャンセルした予約</button>
                        </li>
                    </ul>

                    {{-- タブの中身 --}}
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                            <p>Upcoming reservations will appear here.</p>
                        </div>
                        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                            <p>Past reservations will appear here.</p>
                        </div>
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                            <p>Cancelled reservations will appear here.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
