@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/edit-profile.css') }}">
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
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        Profile Information
                    </div>

                    <div class="card-body">
                        {{-- フォームの開始: 画像を送るために enctype が必須です 📸 --}}
                    <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="text-center mb-4">
                                <img src="{{ $user->detail->avatar ? asset('storage/' . $user->detail->avatar) : 'https://via.placeholder.com/100' }}" 
                                     class="rounded-circle mb-2" alt="Profile Image" style="width: 100px; height: 100px; object-fit: cover;">
                                
                                <div class="mt-2">
                                    <input type="file" name="avatar" class="form-control form-control-sm">
                                </div>
                                <div class="small text-muted mt-1">
                                    Upload profile photo
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label text-muted small">First Name</label>
                                    {{-- name属性を追加し、valueを $user->detail から取得するように修正 👤 --}}
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->detail->first_name ?? '') }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->detail->last_name ?? '') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">Email</label>
                                {{-- EmailはUserテーブルにあるので直接 $user->email --}}
                                <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                <small class="text-muted">Email cannot be changed here.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">Phone</label>
                                {{-- モデルに合わせて phone に修正 📱 --}}
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->detail->phone ?? '') }}">
                            </div>

                            <div class="d-flex justify-content-end mt-4 gap-2">
                                <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                                    Back
                                </button>

                                <button type="submit" class="btn btn-primary px-4">
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