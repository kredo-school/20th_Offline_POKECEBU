@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-restaurant.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6FA9DE; height:80px;">
    <div class="container">
        <span class="navbar-brand fw-bold">Restaurant My Page</span>
    </div>
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">

        {{-- 左メニュー --}}
        <div class="col-3 d-flex flex-column mb-4">
            <span class="px-3 py-2 fw-bold text-muted">Menu</span>
            <span class="px-3 py-2 rounded menu-item mb-1">Restaurant Profile</span>
            <span class="px-3 py-2 rounded menu-item mb-1">Reservations</span>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Restaurant Information</span>
                    <a href="{{ route('staff.edit-restaurant') }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $restaurant && $restaurant->image_path ? asset('storage/' . $restaurant->image_path) : 'https://via.placeholder.com/120' }}"
                             class="rounded me-3" alt="Restaurant Image">
                        <div>
                            <h5 class="mb-1">{{ $restaurant->name ?? 'Sample Restaurant' }}</h5>
                            <p class="mb-0 text-muted">{{ $restaurant->description ?? 'No incoformation' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Owner / Manager</label>
                            <input type="text" class="form-control" value="{{ $restaurant->owner_name ?? 'No incoformation' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="text" class="form-control" value="{{ $restaurant->email ?? 'No incoformation' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control" value="{{ $restaurant->phone ?? 'No incoformation' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Website</label>
                            <input type="text" class="form-control" value="{{ $restaurant->website ?? 'No incoformation' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <input type="text" class="form-control" value="{{ $restaurant->address ?? 'No incoformation' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Description</label>
                        <textarea class="form-control" rows="4" readonly>{{ $restaurant->description ?? 'No incoformation' }}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
