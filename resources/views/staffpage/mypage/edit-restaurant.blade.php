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

            <form action="{{ route('staff.update-restaurant') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">Edit Restaurant Information</div>
                    <div class="card-body">

                        {{-- レストラン画像 --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Restaurant Image</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ $restaurant && $restaurant->image_path ? asset('storage/' . $restaurant->image_path) : 'https://via.placeholder.com/120' }}"
                                     class="rounded me-3" alt="Restaurant Image">
                                <input type="file" name="image_path" class="form-control">
                            </div>
                        </div>

                        {{-- レストラン名 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Restaurant Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $restaurant->name ?? '' }}">
                        </div>

                        {{-- オーナー / 管理者 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Owner / Manager</label>
                            <input type="text" name="owner_name" class="form-control"
                                   value="{{ $restaurant->owner_name ?? '' }}">
                        </div>

                        {{-- メール・電話 --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ $restaurant->email ?? '' }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ $restaurant->phone ?? '' }}">
                            </div>
                        </div>

                        {{-- Webサイト --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Website</label>
                            <input type="text" name="website" class="form-control"
                                   value="{{ $restaurant->website ?? '' }}">
                        </div>

                        {{-- 住所 --}}
                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <input type="text" name="address" class="form-control"
                                   value="{{ $restaurant->address ?? '' }}">
                        </div>

                        {{-- 説明文 --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ $restaurant->description ?? '' }}</textarea>
                        </div>

                        {{-- ボタン --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('staff.mypage.restaurant') }}"
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
