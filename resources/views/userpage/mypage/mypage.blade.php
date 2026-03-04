@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/mypage.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap"
        rel="stylesheet">
@endpush
@section('content')
    <div class="mypage-wrapper">

        {{-- 左サイドバー --}}
        <aside class="ig-sidebar">

            {{-- サイドバー内アバター＋名前 --}}
            <div class="ig-sidebar-profile">
                <div class="ig-sidebar-avatar">
                    <div class="ig-sidebar-avatar-inner">
                        {{-- 変更後 --}}
                        @if ($user->detail?->avatar && str_starts_with($user->detail->avatar, 'data:'))
                            <img src="{{ $user->detail->avatar }}" alt="avatar">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="ig-sidebar-name">
                    {{ $user->detail?->first_name ?? '' }} {{ $user->detail?->last_name ?? 'ユーザー' }}
                </div>
                <div class="ig-sidebar-email">{{ $user->email }}</div>
            </div>

            {{-- ナビゲーション --}}
            <nav class="ig-sidebar-nav">
                <a href="{{ route('mypage') }}" class="ig-nav-item active">
                    <i class="fa-regular fa-user"></i> Profile
                </a>
                <a href="{{ route('user.mypage.post') }}" class="ig-nav-item">
                    <i class="fa-regular fa-images"></i> Posts
                </a>
                <a href="{{ route('booking') }}" class="ig-nav-item">
                    <i class="fa-regular fa-calendar"></i> Bookings
                </a>
                <a href="{{ route('favorite') }}" class="ig-nav-item">
                    <i class="fa-regular fa-heart"></i> Favorite
                </a>
            </nav>
        </aside>

        {{-- 右コンテンツ --}}
        <main class="ig-content">

            {{-- プロフィールヘッダー --}}
            <div class="ig-profile-card">
                <div class="ig-avatar-ring">
                    <div class="ig-avatar-inner">
                        {{-- 変更後 --}}
                        @if ($user->detail?->avatar && str_starts_with($user->detail->avatar, 'data:'))
                            <img src="{{ $user->detail->avatar }}" alt="avatar">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="ig-profile-info">
                    <div class="ig-username">
                        <span>{{ $user->detail->first_name ?? '' }} {{ $user->detail->last_name ?? 'ユーザー' }}</span>
                    </div>
                    <div class="ig-email">{{ $user->email }}</div>
                    <a href="{{ route('edit.profile') }}" class="ig-edit-btn">Edit Profile</a>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="ig-info-card">
                <div class="ig-card-header">
                    <span>Personal Information</span>
                    <a href="{{ route('mypage.edit') }}" class="ig-card-edit-btn">Edit</a>
                </div>
                <div class="ig-card-body">
                    <div class="ig-field-group">
                        <div class="ig-field">
                            <label>First Name</label>
                            <div class="ig-field-value {{ !$user->detail?->first_name ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->first_name ?: '—' }}
                            </div>
                        </div>
                        <div class="ig-field">
                            <label>Last Name</label>
                            <div class="ig-field-value {{ !$user->detail?->last_name ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->last_name ?: '—' }}
                            </div>
                        </div>
                    </div>
                    <div class="ig-field-group">
                        <div class="ig-field">
                            <label>Email</label>
                            <div class="ig-field-value">{{ $user->email }}</div>
                        </div>
                        <div class="ig-field">
                            <label>Phone</label>
                            <div class="ig-field-value {{ !$user->detail?->phone ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->phone ?: '—' }}
                            </div>
                        </div>
                    </div>
                    <div class="ig-field-group" style="grid-template-columns: 1fr 1fr; max-width: 50%;">
                        <div class="ig-field">
                            <label>Date of Birth</label>
                            <div class="ig-field-value {{ !$user->detail?->birthday ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->birthday ?: '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information --}}
            <div class="ig-info-card">
                <div class="ig-card-header">
                    <span>Address Information</span>
                    <a href="{{ route('edit.adress') }}" class="ig-card-edit-btn">Edit</a>
                </div>
                <div class="ig-card-body">
                    <div class="ig-field-group single">
                        <div class="ig-field">
                            <label>Street Address</label>
                            <div class="ig-field-value {{ !$user->detail?->street_address ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->street_address ?: '—' }}
                            </div>
                        </div>
                    </div>
                    <div class="ig-field-group triple">
                        <div class="ig-field">
                            <label>City</label>
                            <div class="ig-field-value {{ !$user->detail?->city ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->city ?: '—' }}
                            </div>
                        </div>
                        <div class="ig-field">
                            <label>State / Province</label>
                            <div class="ig-field-value {{ !$user->detail?->state ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->state ?: '—' }}
                            </div>
                        </div>
                        <div class="ig-field">
                            <label>Postal Code</label>
                            <div class="ig-field-value {{ !$user->detail?->postal_code ? 'ig-field-empty' : '' }}">
                                {{ $user->detail?->postal_code ?: '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
