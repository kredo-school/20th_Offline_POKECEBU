@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/mypage.css') }}">
@endpush


@section('content')
    <div class="container mt-5">
        <div class="row">
            {{-- 左メニュー --}}
            <div class="col-3 d-flex flex-column mb-4">
                <a href="{{ route('mypage') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Profile</a>
                <a href="{{ route('booking') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Bookings</a>
                <a href="{{ route('favorite') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>
            </div>

            {{-- 右コンテンツ --}}
            <div class="col-9">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Profile</span>
                        <a href="{{ route('edit.profile') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- プロフィール画像セクション修正 --}}
                            <div class="d-flex flex-column align-items-center mb-3 col-2">
                                <div class="avatar-wrapper">
                                    @if ($user->detail?->avatar)
                                        {{-- 画像がある場合 --}}
                                        <img src="{{ $user->detail->avatar }}" class="rounded-circle" alt="Profile Image"
                                            style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                                    @else
                                        {{-- 画像がない場合：初期設定アイコン (インスタ風) --}}
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                            style="width: 100px; height: 100px; border: 1px solid #ddd;">
                                            <i class="fa-solid fa-user text-secondary" style="font-size: 50px;"></i>
                                        </div>
                                        {{-- 右下の＋ボタン --}}
                                        <a href="{{ route('user.edit.profile') }}" class="avatar-add-badge shadow-sm">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-10">

                                <h5>{{ $user->detail->first_name ?? '苗字' }} {{ $user->detail->last_name ?? '名前' }}</h5>
                                <p class="mb-0 text-muted">{{ $user->email }}</p>

                                <p class="mb-0 text-muted">{{ $user->detail->phone ?? '電話番号' }}</p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Personal Information --}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Personal Information</span>
                        <a href="{{ route('mypage.edit') }}" class="btn btn-primary btn-sm">Edit Personal Information</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">First Name</label>
                                <input type="text" class="form-control" value="{{ $user->detail->first_name ?? '' }}"
                                    readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Last Name</label>
                                <input type="text" class="form-control" value="{{ $user->detail->last_name ?? '' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Phone</label>
                                <input type="text" class="form-control" value="{{ $user->detail->phone ?? '' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Date of Birth</label>
                                <input type="text" class="form-control" value="{{ $user->detail->birthday ?? '' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Address Information (こちらも同様に detail 経由にします) 🏠 --}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Address Information</span>
                        <a href="{{ route('edit.adress') }}" class="btn btn-primary btn-sm">Edit Adress</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label text-muted">Street Address</label>
                                <input type="text" class="form-control"
                                    value="{{ $user->detail->street_address ?? '' }}" readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">City</label>
                                <input type="text" class="form-control" value="{{ $user->detail->city ?? '' }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">State / Province</label>
                                <input type="text" class="form-control" value="{{ $user->detail->state ?? '' }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Postal Code</label>
                                <input type="text" class="form-control" value="{{ $user->detail->postal_code ?? '' }}"
                                    readonly>
                            </div>
                            {{-- <div class="col-12">
                                <label class="form-label text-muted">Country</label>
                                <input type="text" class="form-control" value="{{ $user->detail->country ?? '' }}" readonly>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
