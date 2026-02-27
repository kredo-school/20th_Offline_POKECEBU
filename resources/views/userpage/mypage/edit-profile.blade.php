@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/edit-profile.css') }}">
@endpush


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header fw-semibold">
                        Profile Information
                    </div>

                    <div class="card-body">
                        {{-- 1. バリデーションエラー（JPGのみ等）の表示 🛡️ --}}
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- 2. プロフィール画像セクション --}}
                        <div class="text-center mb-4">
                            <img src="{{ $user->detail?->avatar ?? 'https://via.placeholder.com/100' }}"
                                class="rounded-circle mb-2" alt="Profile Image"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ddd;">
                            
                            {{-- 写真がある時だけ削除ボタンを表示。ルート名は user. を付与 --}}
                            @if($user->detail?->avatar)
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm text-danger fw-bold" 
                                            onclick="if(confirm('Are you sure you want to remove your photo?')) { document.getElementById('delete-avatar-form').submit(); }">
                                        Remove Photo
                                    </button>
                                </div>
                            @endif

                            {{-- 更新用メインフォーム --}}
                            <form action="{{ route('user.update.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mt-2">
                                    <input type="file" name="avatar" class="form-control form-control-sm">
                                </div>
                                <div class="small text-muted mt-1">
                                    Accepted format: <strong>JPG, JPEG only</strong>
                                </div>
                        </div>

                        {{-- 3. 入力フィールド --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ old('first_name', $user->detail->first_name ?? '') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="{{ old('last_name', $user->detail->last_name ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email cannot be changed here.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $user->detail->phone ?? '') }}">
                        </div>

                        {{-- ボタン --}}
                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                                Back
                            </button>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                Save Changes
                            </button>
                        </div>
                        </form>

                        {{-- 4. 写真削除用の隠しフォーム（名前を user.delete.avatar に修正） --}}
                        <form id="delete-avatar-form" action="{{ route('user.delete.avatar') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection