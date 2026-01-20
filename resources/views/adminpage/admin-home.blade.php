@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css/admin.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm"
     style="background-color:#96CCB9; height:80px;">
    @include('layouts.partials.nav-admin')
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 左サイドメニュー -->
        <div class="col-md-2 bg-light vh-100 p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}"
                       href="{{ route('admin.customers') }}">
                        Customers
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.hotels') ? 'active' : '' }}"
                       href="{{ route('admin.hotels') }}">
                        Hotels
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.restaurants') ? 'active' : '' }}"
                       href="{{ route('admin.restaurants') }}">
                        Restaurants
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.admins') ? 'active' : '' }}"
                       href="{{ route('admin.admins') }}">
                        Admins
                    </a>
                </li>
            </ul>
        </div>

        <!-- 右側 -->
        <div class="col-md-10 p-4">
            @yield('admin-content')
        </div>
    </div>
</div>
@endsection
