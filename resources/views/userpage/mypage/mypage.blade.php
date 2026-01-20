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
            <div class="card mb-4">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3 col-3">
                            <img src="https://via.placeholder.com/80" alt="User Photo" class="rounded-circle me-3">
                        </div>
                        <div class="col-9">
                            <h5>{{ $user->first_name ?? '苗字' }} {{ $user->last_name ?? '名前' }}</h5>
                            <p class="mb-0 text-muted">{{ $user->email }}</p>
                            <p class="mb-0 text-muted">{{ $user->phonenumber ?? '電話番号' }}</p>
                            <a href="{{ route('mypage.editprofile') }}" class="btn btn-primary mt-2">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Personal Information</span>
                    <a href="{{ route('mypage.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">First Name</label>
                            <input type="text" class="form-control" value="{{ $user->first_name ?? '田原' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Last Name</label>
                            <input type="text" class="form-control" value="{{ $user->last_name ?? '志穏' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email ?? 'shi****928@gmail.com' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control" value="{{ $user->phonenumber ?? '070-XXXX-XXXX' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Date of Birth</label>
                            <input type="text" class="form-control" value="{{ $user->birthday ?? '誕生日' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Address Information</span>
                    <a href="{{ route('mypage.editadress') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label text-muted">Street Address</label>
                            <input type="text" class="form-control" value="{{ $user->street_address ?? '住所' }}" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">City</label>
                            <input type="text" class="form-control" value="{{ $user->city ?? '市町村' }}" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">State / Province</label>
                            <input type="text" class="form-control" value="{{ $user->state ?? '都道府県' }}" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Postal Code</label>
                            <input type="text" class="form-control" value="{{ $user->postal_code ?? '000-0000' }}" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Country</label>
                            <input type="text" class="form-control" value="{{ $user->country ?? 'Japan' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
