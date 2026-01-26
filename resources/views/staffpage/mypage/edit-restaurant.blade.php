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
                <div class="card-header">Edit Restaurant Information</div>
                <div class="card-body">

                    {{-- レストラン画像 --}}
                    <div class="mb-4">
                        <label class="form-label text-muted">Restaurant Image</label>
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/120"
                                 class="rounded me-3"
                                 alt="Restaurant Image">
                            <input type="file" class="form-control">
                        </div>
                    </div>

                    {{-- レストラン名 --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Restaurant Name</label>
                        <input type="text" class="form-control"
                               value="Sample Restaurant">
                    </div>

                    {{-- オーナー / 管理者 --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Owner / Manager</label>
                        <input type="text" class="form-control"
                               value="Hanako Suzuki">
                    </div>

                    {{-- メール・電話 --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" class="form-control"
                                   value="restaurant@example.com">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control"
                                   value="080-1111-2222">
                        </div>
                    </div>

                    {{-- Webサイト --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Website</label>
                        <input type="text" class="form-control"
                               value="https://samplerestaurant.com">
                    </div>

                    {{-- 住所 --}}
                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <input type="text" class="form-control"
                               value="4-5-6 Ebisu, Tokyo, Japan">
                    </div>

                    {{-- 説明文 --}}
                    <div class="mb-4">
                        <label class="form-label text-muted">Description</label>
                        <textarea class="form-control" rows="4">This restaurant serves fresh local ingredients and seasonal menus.</textarea>
                    </div>

                    {{-- ボタン --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('staff.edit-restaurant') }}"
                           class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button class="btn btn-primary" disabled>
                            Save (Demo)
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
