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
        <span class="navbar-brand fw-bold">Restaurant My Page</span>
    </div>
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">

        {{-- 左メニュー --}}
        <div class="col-3 d-flex flex-column mb-4">
            <span class="px-3 py-2 rounded menu-item mb-1">Restaurant Profile</span>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">

            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Restaurant Information</span>

                    <a href="{{ route('staff.edit.restaurant') }}"
                       class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </div>

                <div class="card-body">

                    {{-- Restaurant Image --}}
                    <div class="mb-4">
                        <label class="form-label text-muted">Restaurant Image</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ $restaurant && $restaurant->image_path ? asset('storage/' . $restaurant->image_path) : 'https://via.placeholder.com/120' }}"
                                 class="rounded me-3"
                                 width="120"
                                 alt="Restaurant Image">
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Restaurant Name</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->name ?? '-' }}" readonly>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Description</label>
                        <textarea class="form-control" rows="4" readonly>{{ $restaurant->description ?? '-' }}</textarea>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->address ?? '-' }}" readonly>
                    </div>

                    {{-- City --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">City</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->city ?? '-' }}" readonly>
                    </div>

                    {{-- Latitude / Longitude --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Latitude</label>
                            <input type="text" class="form-control"
                                   value="{{ $restaurant->latitude ?? '-' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Longitude</label>
                            <input type="text" class="form-control"
                                   value="{{ $restaurant->longitude ?? '-' }}" readonly>
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Star Rating</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->star_rating ?? '-' }}" readonly>
                    </div>

                    {{-- Email / Phone --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Restaurant Email</label>
                            <input type="text" class="form-control"
                                   value="{{ $restaurant->email ?? '-' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control"
                                   value="{{ $restaurant->phone ?? '-' }}" readonly>
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Website</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->website ?? '-' }}" readonly>
                    </div>

                    {{-- Representative --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Representative Name</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->representative_name ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Representative Email</label>
                        <input type="text" class="form-control"
                               value="{{ $restaurant->representative_email ?? '-' }}" readonly>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection