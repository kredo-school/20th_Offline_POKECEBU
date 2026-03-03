@extends('layouts.admin')

@section('title', 'Admin Analysis of Users')

@section('content')
<style>
    .analysis-wrapper { background: #f4f7f6; min-height: 100vh; padding: 20px; }
    
    /* サイドバー統一スタイル */
    .btn-sidebar { 
        border: none; padding: 12px 20px; border-radius: 12px; color: #64748b; 
        transition: all 0.3s; background: white; width: 100%; display: block; 
        margin-bottom: 10px; text-decoration: none; text-align: left; 
    }
    .btn-sidebar:hover { background: #f1f5f9; color: #1e293b; transform: translateX(5px); }
    .btn-sidebar.active { 
        background: #3b82f6 !important; color: white !important; 
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); 
    }

    .kpi-box { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: 100%; }
    .analysis-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); margin-bottom: 25px; border: none; }
    .chart-title { font-weight: 700; color: #334155; margin-bottom: 15px; display: flex; align-items: center; }
    .chart-wrapper { position: relative; height: 350px; width: 100%; }
    .fw-extrabold { font-weight: 800; }
</style>

<div class="analysis-wrapper">
    <div class="row g-5"> 
        
        {{-- 1. Sidebar --}}
        <div class="col-lg-2">
            <div class="d-flex flex-column mb-4">
                <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar">
                    <i class="fa-solid fa-hotel me-2"></i>Hotel
                </a>
                <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar">
                    <i class="fa-solid fa-utensils me-2"></i>Restaurant
                </a>
                <a href="{{ route('admin.analysis.user') }}" class="btn btn-sidebar active">
                    <i class="fa-solid fa-users-gear me-2"></i>User Insights
                </a>
            </div>
            <div class="mt-4">
                <label class="small fw-bold text-muted mb-2 ms-1">Target Role</label>
                <div class="p-2 bg-white rounded-3 shadow-sm small text-center text-muted">
                    General Consumers (Role 1)
                </div>
            </div>
        </div>

        {{-- 2. Main Content --}}
        <div class="col-lg-10">
            
            {{-- KPI Section --}}
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="kpi-box shadow-sm border-start border-primary border-5">
                        <p class="text-muted small fw-bold mb-2">TOTAL PLATFORM USERS</p>
                        <h3 class="fw-extrabold m-0">{{ number_format($totalUsers) }}</h3>
                        <span class="badge bg-light text-muted mt-2 border">Cumulative Account</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kpi-box shadow-sm border-start border-info border-5">
                        <p class="text-muted small fw-bold mb-2 text-info">NEW SIGNUPS (MONTHLY)</p>
                        <h3 class="fw-extrabold text-info m-0">{{ number_format($newThisMonth) }}</h3>
                        <span class="badge bg-info bg-opacity-10 text-info mt-2">March 2026</span>
                    </div>
                </div>
            </div>

            {{-- Table Toggle --}}
            <div class="text-center mb-5">
                <button class="btn btn-dark rounded-pill px-5 shadow-sm fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#detailedUserTable">
                    <i class="fa-solid fa-table-list me-2"></i>View Monthly Registration History
                </button>
            </div>

            <div class="collapse mb-5" id="detailedUserTable">
                <div class="analysis-card p-0 overflow-hidden shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center m-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start ps-4 py-3">Period</th>
                                    <th>Signups</th>
                                    <th class="text-end pe-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthlyUserStats as $data)
                                    <tr>
                                        <td class="text-start ps-4 fw-bold text-dark">{{ $data->month_name }}</td>
                                        <td><span class="fw-bold">{{ number_format($data->signups) }}</span></td>
                                        <td class="text-end pe-4">
                                            @if($data->signups > 0)
                                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 border border-success border-opacity-25">Growing</span>
                                            @else
                                                <span class="text-muted small">Stable</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="analysis-card shadow-sm h-100">
                        <h6 class="chart-title border-bottom pb-3">
                            <i class="fa-solid fa-chart-line me-2 text-primary"></i>Annual User Acquisition Trend
                        </h6>
                        <div class="chart-wrapper mt-3">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="analysis-card shadow-sm h-100">
                        <h6 class="chart-title border-bottom pb-3">
                            <i class="fa-solid fa-user-check me-2 text-success"></i>Booking Activity Rate
                        </h6>
                        <div class="chart-wrapper mt-3" style="height: 280px;">
                            <canvas id="userActivityChart"></canvas>
                        </div>
                        <div class="mt-4 text-center">
                            <small class="text-muted">Users with at least one confirmed reservation.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Growth Trend Chart
        const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const gradient = growthCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    data: @json($growthData),
                    borderColor: '#3b82f6',
                    borderWidth: 4,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Booking Activity Doughnut Chart
        const activityCtx = document.getElementById('userActivityChart').getContext('2d');
        const activityData = @json($activityData);

        new Chart(activityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active (Reserved)', 'Inactive (No Booking)'],
                datasets: [{
                    data: [activityData.active, activityData.inactive],
                    backgroundColor: ['#10b981', '#f1f5f9'],
                    borderColor: ['#ffffff', '#ffffff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '78%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, padding: 20 } },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                let total = activityData.active + activityData.inactive;
                                let val = c.raw;
                                let pct = total > 0 ? Math.round((val / total) * 100) : 0;
                                return `${c.label}: ${val} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection