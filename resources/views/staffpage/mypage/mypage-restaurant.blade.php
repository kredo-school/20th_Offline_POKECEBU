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
            <span class="px-3 py-2 fw-bold text-muted">Menu</span>
            <span class="px-3 py-2 rounded menu-item mb-1">Restaurant Profile</span>
            <span class="px-3 py-2 rounded menu-item mb-1">Reservations</span>
        </div>

        {{-- 右コンテンツ --}}
        <div class="col-9">

            {{-- レストラン基本情報 --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Restaurant Information</span>
                    <a href="{{ route('staff.edit-restaurant') }}"
                       class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://via.placeholder.com/120"
                             class="rounded me-3"
                             alt="Restaurant Image">
                        <div>
                            <h5 class="mb-1">Sample Restaurant</h5>
                            <p class="mb-0 text-muted">Casual dining with local cuisine</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Owner / Manager</label>
                            <input type="text" class="form-control"
                                   value="Hanako Suzuki" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="text" class="form-control"
                                   value="restaurant@example.com" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Phone</label>
                            <input type="text" class="form-control"
                                   value="080-1111-2222" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Website</label>
                            <input type="text" class="form-control"
                                   value="https://samplerestaurant.com" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <input type="text" class="form-control"
                               value="4-5-6 Ebisu, Tokyo, Japan"
                               readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Description</label>
                        <textarea class="form-control" rows="4" readonly>
This restaurant serves fresh local ingredients and seasonal menus.
                        </textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
