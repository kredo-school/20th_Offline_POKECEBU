@extends('layouts.app')

@push('styles')
<style>
.menu-item { transition: background-color 0.2s ease, color 0.2s ease; }
.menu-item:hover { background-color: #f0f4ff; color: #0d6efd; }
</style>
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
            <a href="{{ route('bookings') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">My Booking</a>
            <a href="{{ route('favorites') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">
            <div class="card mb-4 w-100">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn-group w-100" role="group" aria-label="Favorite Type">
                            <input type="radio" class="btn-check" name="favoriteType" id="all" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="all">All</label>
                            <input type="radio" class="btn-check" name="favoriteType" id="hotel" autocomplete="off">
                            <label class="btn btn-outline-primary" for="hotel">Hotel</label>
                            <input type="radio" class="btn-check" name="favoriteType" id="restaurant" autocomplete="off">
                            <label class="btn btn-outline-primary" for="restaurant">Restaurant</label>
                        </div>
                    </div>

                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">You have no favorites yet.</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
