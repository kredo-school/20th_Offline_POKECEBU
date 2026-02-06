@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-hotel.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6FA9DE; height:80px;">
    <div class="container">
        <span class="navbar-brand fw-bold">Hotel My Page</span>
    </div>
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">

        {{-- 左メニュー --}}
        <div class="col-3 d-flex flex-column mb-4">
            <span class="px-3 py-2 rounded menu-item mb-1">Hotel Profile</span>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Hotel Information</span>
                    <a href="{{ route('staff.mypage.hotel.edit') }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </div>

                <div class="card-body">

                    {{-- ホテル画像と基本情報 --}}
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $hotel && $hotel->image_path ? asset('storage/' . $hotel->image_path) : 'https://via.placeholder.com/120' }}"
                             class="rounded me-3" alt="Hotel Image">
                        <div>
                            <h5 class="mb-1">{{ $hotel->name ?? 'Sample Hotel' }}</h5>
                            <p class="mb-0 text-muted">{{ $hotel->description ?? 'No information' }}</p>
                        </div>
                    </div>

                    {{-- 代表者・メール --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Representative</label>
                            <input type="text" class="form-control" value="{{ $hotel->representative_name ?? 'No information' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="text" class="form-control" value="{{ $hotel->email ?? 'No information' }}" readonly>
                        </div>
                    </div>

                    {{-- 電話・Web --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control" value="{{ $hotel->phone ?? 'No information' }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Website</label>
                            <input type="text" class="form-control" value="{{ $hotel->website ?? 'No information' }}" readonly>
                        </div>
                    </div>

                    {{-- 住所 --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <input type="text" class="form-control" value="{{ $hotel->address ?? 'No information' }}" readonly>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
