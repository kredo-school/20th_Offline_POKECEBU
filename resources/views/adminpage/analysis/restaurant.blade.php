@extends('layouts.admin')

@section('title', 'Admin Analysis of Restaurant')

@section('content')
<style>
    .analysis-wrapper { background: #fdfcf9; min-height: 100vh; padding: 20px; }
    .btn-sidebar { border: none; padding: 12px 20px; border-radius: 12px; color: #64748b; transition: all 0.3s; background: white; width: 100%; display: block; margin-bottom: 10px; text-decoration: none; }
    .btn-sidebar:hover { background: #fff7ed; color: #ea580c; transform: translateX(5px); }
    .btn-sidebar.active { background: #f59e0b; color: white !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    .kpi-card { border-radius: 20px; border: none; background: white; transition: 0.3s; }
    .analysis-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); margin-bottom: 25px; border: none; }
    .chart-title { font-weight: 700; color: #431407; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 20px; }
    .chart-wrapper { position: relative; height: 300px; width: 100%; }
    .fw-black { font-weight: 900; }
</style>

<div class="analysis-wrapper">
    <div class="container-fluid">
        <div class="row g-4">
            {{-- 1. Sidebar --}}
            <div class="col-lg-2">
                <div class="sticky-top" style="top: 20px;">
                    <h5 class="fw-bold mb-4 ps-2 text-dark">Admin Console</h5>
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar shadow-sm">
                        <i class="fa-solid fa-hotel me-2"></i>Hotel
                    </a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar active shadow-sm">
                        <i class="fa-solid fa-utensils me-2"></i>Restaurant
                    </a>
                    <a href="{{ route('admin.analysis.user') }}" class="btn btn-sidebar shadow-sm">
                        <i class="fa-solid fa-users-gear me-2"></i>User Insights
                    </a>

                    <div class="mt-4 p-2">
                        <label class="small fw-bold text-muted mb-2 d-block">Restaurant Selector</label>
                        <select class="form-select border-0 shadow-sm rounded-3 py-2" onchange="window.location.href=this.value">
                            <option value="{{ route('admin.analysis.restaurant') }}" {{ is_null($restaurantId) ? 'selected' : '' }}>All Restaurants</option>
                            @foreach ($restaurants as $res)
                                <option value="{{ route('admin.analysis.restaurant', ['id' => $res->id]) }}" {{ $restaurantId == $res->id ? 'selected' : '' }}>{{ $res->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. Main Content --}}
            <div class="col-lg-10">
                {{-- KPI Cards --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card kpi-card shadow-sm p-4">
                            <p class="text-muted small fw-bold mb-1">RESERVATIONS</p>
                            <h2 class="fw-black m-0">{{ number_format($kpi->total_bookings ?? 0) }}</h2>
                            <span class="badge bg-light text-muted mt-2 border">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card kpi-card shadow-sm p-4 border-start border-warning border-5">
                            <p class="text-muted small fw-bold mb-1 text-warning">TOTAL GUESTS</p>
                            <h2 class="fw-black text-warning m-0">{{ number_format($kpi->total_guests ?? 0) }}</h2>
                            <span class="badge bg-warning bg-opacity-10 text-warning mt-2">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card kpi-card shadow-sm p-4 border-start border-success border-5">
                            <p class="text-muted small fw-bold mb-1 text-success">AVG. DINING TIME</p>
                            <h2 class="fw-black text-success m-0">{{ number_format($avgStayTime ?? 0) }}<span class="fs-4 ms-1">min</span></h2>
                            <span class="badge bg-success bg-opacity-10 text-success mt-2">Per Table</span>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-5">
                    <button class="btn btn-outline-warning rounded-pill px-5 shadow-sm fw-bold border-2" type="button" data-bs-toggle="collapse" data-bs-target="#yearlyReport">
                        <i class="fa-solid fa-chart-pie me-2"></i>Show Annual Metrics
                    </button>
                </div>

                <div class="collapse mb-5" id="yearlyReport">
                    <div class="analysis-card p-0 overflow-hidden shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start ps-4 py-3">Month</th>
                                        <th>Bookings</th>
                                        <th>Guests</th>
                                        <th class="text-end pe-4">Avg. Stay (min)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                        <tr class="{{ now()->month - 1 == $i ? 'table-warning' : '' }}">
                                            <td class="text-start ps-4 fw-bold">{{ $monthName }}</td>
                                            <td>{{ number_format($monthlyBookings[$i] ?? 0) }}</td>
                                            <td>{{ number_format($monthlyGuests[$i] ?? 0) }}</td>
                                            <td class="text-end pe-4 fw-bold">{{ number_format($monthlyAvgStay[$i] ?? 0, 1) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Daily Reservations Chart (NEW Section) --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="analysis-card shadow-sm h-100">
                            <h6 class="chart-title"><i class="fa-solid fa-clock me-2 text-warning"></i>Peak Hours (Arrivals)</h6>
                            <div class="chart-wrapper mt-3"><canvas id="hourlyPeakChart"></canvas></div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-7">
                        <div class="analysis-card shadow-sm">
                            <h6 class="chart-title">
                                <i class="fa-solid fa-calendar-day me-2 text-warning"></i>Daily Reservation Count ({{ now()->format('F Y') }})
                            </h6>
                            <div class="chart-wrapper"style="height: 350px;">
                                <canvas id="dailyStatsChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="analysis-card shadow-sm h-100">
                            <h6 class="chart-title"><i class="fa-solid fa-chart-line me-2 text-warning"></i>Monthly Booking Trend</h6>
                            <div class="chart-wrapper mt-3"><canvas id="monthlyTrendChart"></canvas></div>
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
        // --- 1. Daily Reservations Bar Chart ---
        const dailyDataRaw = @json($dailyData);
        const dailyLabels = Object.keys(dailyDataRaw);
        const dailyValues = Object.values(dailyDataRaw);

        new Chart(document.getElementById('dailyStatsChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels.map(day => day + '日'),
                datasets: [{
                    label: 'Reservations',
                    data: dailyValues,
                    backgroundColor: '#f59e0b',
                    borderRadius: 6,
                    hoverBackgroundColor: '#ea580c'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- 2. Hourly Line Chart ---
        const hourlyStats = @json($hourlyStats);
        new Chart(document.getElementById('hourlyPeakChart'), {
            type: 'line',
            data: {
                labels: Array.from({ length: 24 }, (_, i) => i + ':00'),
                datasets: [{
                    label: 'Arrivals',
                    data: Object.values(hourlyStats),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // --- 3. Monthly Bar Chart ---
        const monthlyBookings = @json($monthlyBookings);
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        new Chart(document.getElementById('monthlyTrendChart'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Bookings',
                    data: monthlyBookings,
                    backgroundColor: '#fbbf24',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection