@extends('layouts.admin')

@section('title', 'Admin Home')

@section('content')

    <div class="container py-4">
        <h2 class="mb-4 fw-bold">Admin Dashboard</h2>

        <div class="row justify-content-center mb-5">
            {{-- 全ユーザー数 --}}
            <div class="col-md-5">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <p class="text-muted small fw-bold text-uppercase mb-1">All Users</p>
                        <h3>
                            <a href="{{ route('admin.showAllUsers') }}" class="text-decoration-none text-dark display-6 fw-bold">
                                {{ number_format($totalUsers) }}
                            </a>
                        </h3>
                        <p class="text-muted small mb-0">Registered total</p>
                    </div>
                </div>
            </div>

            {{-- 新規ユーザー数 (今月) --}}
            <div class="col-md-5">
                <div class="card text-center border-0 shadow-sm h-100" style="background: #eef7f9;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <p class="text-muted small fw-bold text-uppercase mb-1">New Registrations</p>
                        <h3 class="display-6 fw-bold text-info">
                            {{ number_format($newRegistrationCount) }}
                        </h3>
                        <p class="text-muted small mb-0">Joined this month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i>Pending Approval</h4>
                    </div>

                    <div class="card-body">
                        {{-- Hotels --}}
                        {{-- @foreach ($pendingHotels as $hotel) --}}
                        <a href="{{ route('admin.showList', 'hotel') }}" class="text-decoration-none text-dark fw-bold">
                            <div class="d-flex align-items-center border rounded p-3 mb-3 bg-light">
                                <div class="col-3">
                                    <i class="fa-solid fa-hotel me-2"></i>Hotel
                                </div>

                                <div class="col-6 text-center">
                                    @if ($countTmpHotel != 0)
                                        <span class="text-danger">Pending: {{ $countTmpHotel }}</span>
                                    @else
                                        Pending: {{ $countTmpHotel }}
                                    @endif
                                </div>

                                <div class="col-3 text-end">
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fa-solid fa-eye"></i> View the list
                                    </span>
                                </div>
                            </div>
                        </a>
                        {{-- @endforeach --}}

                        {{-- Restaurants --}}
                        {{-- @foreach ($pendingRestaurants as $restaurant) --}}
                        <a href="{{ route('admin.showList', 'restaurant') }}" class="text-decoration-none text-dark fw-bold">
                            <div class="d-flex align-items-center border rounded p-3 mb-3 bg-light">
                                <div class="col-3">
                                    <i class="fa-solid fa-utensils me-2"></i>Restaurant
                                </div>

                                <div class="col-6 text-center">
                                    @if ($countTmpHotel != 0)
                                        <span class="text-danger">Pending: {{ $countTmpRestaurant }}</span>
                                    @else
                                        Pending: {{ $countTmpRestaurant }}
                                    @endif
                                </div>

                                <div class="col-3 text-end">
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fa-solid fa-eye"></i> View the list
                                    </span>
                                </div>
                            </div>
                        </a>
                        {{-- @endforeach --}}

                        {{-- No Data Message --}}
                        {{-- @if ($pendingHotels->isEmpty() && $pendingRestaurants->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No pending approvals 🎉</p>
                            </div>  --}}
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection