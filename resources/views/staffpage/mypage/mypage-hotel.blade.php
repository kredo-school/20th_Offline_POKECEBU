@extends('layouts.app')

@push('styles')
    <style>
        .menu-item {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .menu-item:hover {
            background-color: #f0f4ff;
            color: #0d6efd;
        }
    </style>
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

                {{-- ホテル基本情報 --}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Hotel Information</span>
                        <a href="{{ route('staff.edit') }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <img src="https://via.placeholder.com/120" class="rounded me-3" alt="Hotel Image">
                            <div>
                                <h5 class="mb-1">Sample Hotel</h5>
                                <p class="mb-0 text-muted">A cozy hotel near the beach</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Representative</label>
                                <input type="text" class="form-control" value="Taro Yamada" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="text" class="form-control" value="hotel@example.com" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Phone</label>
                                <input type="text" class="form-control" value="090-0000-0000" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Website</label>
                                <input type="text" class="form-control" value="https://samplehotel.com" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <input type="text" class="form-control" value="1-2-3 Shibuya, Tokyo, Japan" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Description</label>
                            <textarea class="form-control" rows="4" readonly>
This hotel offers comfortable rooms and friendly service for all guests.
                        </textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
