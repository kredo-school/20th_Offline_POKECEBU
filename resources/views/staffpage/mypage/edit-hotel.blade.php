@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
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
            <a href="{{ route('staff.mypage.hotel') }}"
               class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">
               Hotel Profile
            </a>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">

            <div class="card mb-4">
                <div class="card-header">Edit Hotel Information</div>
                <div class="card-body">

                    <form method="POST"
                          action="{{ route('staff.mypage.hotel.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- ホテル画像 --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Hotel Image</label>
                            <div class="d-flex align-items-center">
                                <img
                                    src="{{ $hotel && $hotel->image_path
                                        ? asset('storage/' . $hotel->image_path)
                                        : 'https://via.placeholder.com/120' }}"
                                    class="rounded me-3"
                                    width="120"
                                    alt="Hotel Image">

                                <input type="file" name="image_path" class="form-control">
                            </div>
                        </div>

                        {{-- ホテル名 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Hotel Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $hotel->name ?? '') }}"
                                   required>
                        </div>

                        {{-- 代表者名 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Representative</label>
                            <input type="text"
                                   name="representative_name"
                                   class="form-control"
                                   value="{{ old('representative_name', $hotel->representative_name ?? '') }}">
                        </div>

                        {{-- メール・電話 --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $hotel->email ?? '') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $hotel->phone ?? '') }}">
                            </div>
                        </div>

                        {{-- Webサイト --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Website</label>
                            <input type="text"
                                   name="website"
                                   class="form-control"
                                   value="{{ old('website', $hotel->website ?? '') }}">
                        </div>

                        {{-- 住所 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <input type="text"
                                   name="address"
                                   class="form-control"
                                   value="{{ old('address', $hotel->address ?? '') }}">
                        </div>

                        {{-- 説明文 --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="4">{{ old('description', $hotel->description ?? '') }}</textarea>
                        </div>

                        {{-- ボタン --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('staff.mypage.hotel') }}"
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button class="btn btn-primary">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
