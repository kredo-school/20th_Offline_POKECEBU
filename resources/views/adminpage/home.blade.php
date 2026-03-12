@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    <div id="admin-dashboard-root">
        <div class="dashboard-container">
            
            {{-- Header --}}
            <div class="header-section">
                <div>
                    <h1 class="page-title">Overview</h1>
                    <p class="text-muted mb-0">Platform health and registration status.</p>
                </div>
                <div class="date-box">
                    <div class="fw-bold" style="color: var(--primary-blue)">{{ now()->format('Y / m / d') }}</div>
                    <div class="small text-muted">{{ now()->format('l, H:i') }}</div>
                </div>
            </div>

            {{-- KPI Grid --}}
            <div class="kpi-grid">
                <a href="{{ route('admin.showAllUsers') }}" class="kpi-card">
                    <div class="kpi-icon icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="kpi-label">Registered Users</span>
                    <div class="kpi-value">{{ number_format($totalUsers) }}</div>
                    <div class="small text-muted mt-3">
                        View database <i class="fa-solid fa-chevron-right ms-1" style="font-size: 10px"></i>
                    </div>
                </a>

                <div class="kpi-card">
                    <div class="kpi-icon icon-orange">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span class="kpi-label">New this Month</span>
                    <div class="kpi-value">{{ number_format($newRegistrationCount) }}</div>
                    <div class="small text-muted mt-3">
                        Joined in {{ now()->format('F') }}
                    </div>
                </div>

                <a href="{{ route('admin.analysis.user') }}" class="kpi-card">
                    <div class="kpi-icon icon-green">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <span class="kpi-label">System Analytics</span>
                    <div class="kpi-value" style="font-size: 1.75rem">Insights</div>
                    <div class="small text-muted mt-3">
                        Detailed reports <i class="fa-solid fa-chevron-right ms-1" style="font-size: 10px"></i>
                    </div>
                </a>
            </div>

            {{-- Verification Queue --}}
            <div class="list-section">
                <div class="list-header">
                    <i class="fa-solid fa-shield-check me-2 text-primary"></i> Verification Queue
                </div>

                <div class="list-item">
                    <div class="item-info">
                        <i class="fa-solid fa-hotel fs-4 text-muted"></i>
                        <div>
                            <p class="item-title">Hotel Partners</p>
                            <p class="small text-muted mb-0">Review property documents</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        @if ($countTmpHotel > 0)
                            <div class="status-indicator status-alert">
                                <div class="pulse"></div> {{ $countTmpHotel }} Pending
                            </div>
                        @else
                            <div class="status-indicator status-ok">
                                <i class="fa-solid fa-check me-1"></i> All Reviewed
                            </div>
                        @endif
                        <a href="{{ route('admin.showList', 'hotel') }}" class="btn-review">Review</a>
                    </div>
                </div>

                <div class="list-item">
                    <div class="item-info">
                        <i class="fa-solid fa-utensils fs-4 text-muted"></i>
                        <div>
                            <p class="item-title">Restaurant Partners</p>
                            <p class="small text-muted mb-0">Review menu & business licenses</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        @if ($countTmpRestaurant > 0)
                            <div class="status-indicator status-alert">
                                <div class="pulse"></div> {{ $countTmpRestaurant }} Pending
                            </div>
                        @else
                            <div class="status-indicator status-ok">
                                <i class="fa-solid fa-check me-1"></i> All Reviewed
                            </div>
                        @endif
                        <a href="{{ route('admin.showList', 'restaurant') }}" class="btn-review">Review</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection