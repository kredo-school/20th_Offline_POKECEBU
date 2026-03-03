@extends('layouts.admin')

@section('title', 'Admin Analysis of Restaurant')

@section('content')

    <div class="analysis-wrapper">
        <div class="row g-5">
            
            {{-- 1. Sidebar --}}
            <div class="col-lg-2">
                <div class="d-flex flex-column mb-4">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar">
                        <i class="fa-solid fa-hotel me-2"></i>Hotel
                    </a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar active">
                        <i class="fa-solid fa-utensils me-2"></i>Restaurant
                    </a>
                </div>
                
                <div class="mt-4">
                    <label class="small fw-bold text-muted mb-2 ms-1">Select Restaurant</label>
                    <select class="form-select border-0 shadow-sm rounded-3" onchange="window.location.href=this.value">
                        <option value="{{ route('admin.analysis.restaurant') }}" {{ is_null($restaurantId) ? 'selected' : '' }}>All Restaurants</option>
                        @foreach ($restaurants as $res)
                            <option value="{{ route('admin.analysis.restaurant', ['id' => $res->id]) }}" {{ $restaurantId == $res->id ? 'selected' : '' }}>
                                {{ $res->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 2. Main Content --}}
            <div class="col-lg-10">
                
                {{-- KPI Section --}}
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2 text-uppercase">Reservations</p>
                            <h3 class="fw-extrabold m-0">{{ number_format($kpi->total_bookings ?? 0) }}</h3>
                            <span class="badge bg-light text-muted mt-2">This Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2 text-warning text-uppercase">Total Guests</p>
                            <h3 class="fw-extrabold text-warning m-0">{{ number_format($kpi->total_guests ?? 0) }}</h3>
                            <span class="badge bg-light text-muted mt-2">This Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2 text-success text-uppercase">Avg. Dining Time</p>
                            <h3 class="fw-extrabold text-success m-0">{{ number_format($avgStayTime ?? 0) }}<span class="fs-6 ms-1">min</span></h3>
                            <span class="badge bg-light text-muted mt-2">Per Table</span>
                        </div>
                    </div>
                </div>

                {{-- 詳細表示ボタン --}}
                <div class="text-center mb-5">
                    <button class="btn btn-outline-warning btn-detail shadow-sm px-5" type="button" data-bs-toggle="collapse" data-bs-target="#detailedAnalysis">
                        <i class="fa-solid fa-chart-pie me-2"></i>Show Yearly Detailed Report
                    </button>
                </div>

                {{-- Yearly Detailed Area (Hidden by default) --}}
                <div class="collapse mb-4" id="detailedAnalysis">
                    <div class="analysis-card">
                        <h6 class="chart-title border-bottom pb-3">Monthly Business Performance</h6>
                        <div class="chart-wrapper">
                            <canvas id="kpiTrendChart"></canvas>
                        </div>
                    </div>

                    <div class="analysis-card p-0 overflow-hidden shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center m-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th class="text-start ps-4">Month</th>
                                        <th>Bookings</th>
                                        <th>Guests</th>
                                        <th>Avg. Stay (min)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                        <tr class="{{ now()->month - 1 == $i ? 'table-warning text-dark' : '' }}">
                                            <td class="text-start ps-4 fw-bold text-muted">{{ $monthName }}</td>
                                            <td>{{ number_format($monthlyBookings[$i] ?? 0) }}</td>
                                            <td>{{ number_format($monthlyGuests[$i] ?? 0) }}</td>
                                            <td class="fw-bold">{{ number_format($monthlyAvgStay[$i] ?? 0, 1) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Peak Hours Analysis --}}
                <div class="analysis-card">
                    <h6 class="chart-title border-bottom pb-3">
                        <i class="fa-solid fa-clock me-2 text-warning"></i>Peak Hours Concentration
                    </h6>
                    <div class="chart-wrapper mt-3">
                        <canvas id="hourlyPeakChart"></canvas>
                    </div>
                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">Analyzes when guests typically arrive throughout the day.</p>
                    </div>
                </div>

                {{-- Daily Booking Volume --}}
                <div class="analysis-card">
                    <h6 class="chart-title border-bottom pb-3">
                        <i class="fa-solid fa-chart-line me-2 text-warning"></i>Daily Booking Trend ({{ now()->format('F') }})
                    </h6>
                    <div class="chart-wrapper mt-3">
                        <canvas id="dailyBookingChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let resCharts = {};

        document.addEventListener('DOMContentLoaded', function() {
            
            // PHPデータを安全にパース
            const monthlyBookings = @json($monthlyBookings ?? []);
            const monthlyGuests = @json($monthlyGuests ?? []);
            const monthlyAvgStay = @json($monthlyAvgStay ?? []);
            const dailyData = @json($dailyData ?? []);
            const hourlyData = @json($hourlyStats ?? []);

            // --- 1. KPI Trend Chart ---
            const kpiCtx = document.getElementById('kpiTrendChart');
            if (kpiCtx) {
                resCharts['kpiTrendChart'] = new Chart(kpiCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            { label: 'Bookings', data: monthlyBookings, borderColor: '#f39c12', tension: 0.3, yAxisID: 'y' },
                            { label: 'Stay Time', data: monthlyAvgStay, borderColor: '#2ecc71', borderDash: [5, 5], tension: 0.3, yAxisID: 'y1' }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { display: false },
                            y1: { display: false }
                        }
                    }
                });
            }

            // --- 2. Hourly Peak Chart ---
            const hourlyCtx = document.getElementById('hourlyPeakChart');
            if (hourlyCtx) {
                resCharts['hourlyChart'] = new Chart(hourlyCtx, {
                    type: 'line',
                    data: {
                        labels: Array.from({ length: 24 }, (_, i) => i + ':00'),
                        datasets: [{
                            label: 'Arrivals',
                            data: hourlyData,
                            borderColor: '#f39c12',
                            backgroundColor: 'rgba(243, 156, 18, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#f39c12',
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // --- 3. Daily Booking Chart ---
            const dailyCtx = document.getElementById('dailyBookingChart');
            if (dailyCtx) {
                resCharts['dailyChart'] = new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(dailyData).map(day => day + 'd'),
                        datasets: [{
                            label: 'Bookings',
                            data: Object.values(dailyData),
                            borderColor: '#f39c12',
                            backgroundColor: 'rgba(243, 156, 18, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // リサイズ対応
            document.getElementById('detailedAnalysis').addEventListener('shown.bs.collapse', function() {
                if (resCharts['kpiTrendChart']) resCharts['kpiTrendChart'].resize();
            });
        });
    </script>
@endsection