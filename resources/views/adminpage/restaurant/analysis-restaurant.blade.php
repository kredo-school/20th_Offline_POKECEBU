@extends('layouts.admin')

@section('title', 'Admin Analysis of Restaurant')

@section('content')
    <style>
        .btn-sidebar {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: white;
            color: #555;
            width: 100%;
            margin-bottom: 10px;
            transition: all 0.3s;
            text-align: left;
            padding: 12px 20px;
        }

        .btn-sidebar.active {
            background-color: #f39c12;
            color: white;
            border-color: #f39c12;
            font-weight: bold;
        }

        .analysis-container {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 15px;
        }

        .kpi-box {
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            flex: 1;
            min-width: 200px;
            background: #ffffff;
            border: 1px solid #f0f0f0;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-wrapper {
            position: relative;
            height: 350px !important;
            width: 100%;
        }
    </style>

    <div class="container py-4">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-2">
                <div class="d-flex flex-column mb-4">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar"><i
                            class="fa-solid fa-hotel me-2"></i>Hotel</a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar active"><i
                            class="fa-solid fa-utensils me-2"></i>Restaurant</a>
                </div>
                <select class="form-select form-select-sm border-dark-subtle shadow-sm"
                    onchange="window.location.href=this.value">
                    <option value="{{ route('admin.analysis.restaurant') }}" {{ is_null($restaurantId) ? 'selected' : '' }}>
                        All Restaurants</option>
                    @foreach ($restaurants as $res)
                        <option value="{{ route('admin.analysis.restaurant', ['id' => $res->id]) }}"
                            {{ $restaurantId == $res->id ? 'selected' : '' }}>{{ $res->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Main Content --}}
            <div class="col-md-10">
                {{-- KPI Section --}}
                <div class="analysis-container shadow-sm">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Total Reservations</div>
                            <div class="h2 fw-bold text-dark">{{ number_format($kpi->total_bookings ?? 0) }}</div>
                            <div class="text-muted x-small">Current Month</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Total Guests</div>
                            <div class="h2 fw-bold text-warning">{{ number_format($kpi->total_guests ?? 0) }}</div>
                            <div class="text-muted x-small">Current Month</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Avg. Dining Time</div>
                            <div class="h2 fw-bold text-success">{{ number_format($avgStayTime ?? 0) }} min</div>
                            <div class="text-muted x-small">Per Table</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="analysis-container shadow-sm">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-clock me-2 text-warning"></i>Peak Hours Analysis (Current Month)
                            </h6>
                            <div class="chart-wrapper mt-3" style="height: 300px;">
                                <canvas id="hourlyPeakChart"></canvas>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted">"Booking concentration by hour, based on check-in times."</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daily & Monthly Charts --}}
                <div class="row mb-4">
                    {{-- Daily Bookings (折れ線グラフ) --}}
                    <div class="col-md-7">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-chart-line me-2 text-warning"></i>Daily Booking Volume
                                ({{ now()->format('F') }})
                            </h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="dailyBookingChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Trends (棒グラフに一本化) --}}
                    <div class="col-md-5">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-chart-column me-2 text-warning"></i>Monthly Trends
                            </h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="monthlyBarChart"></canvas>
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
            // --- 1. 日次予約トレンド (折れ線グラフ) ---
            const dailyCtx = document.getElementById('dailyBookingChart');
            if (dailyCtx) {
                const dailyData = @json($dailyData);
                new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(dailyData).map(day => day + '日'),
                        datasets: [{
                            label: 'Reservations',
                            data: Object.values(dailyData),
                            borderColor: '#f39c12',
                            backgroundColor: 'rgba(243, 156, 18, 0.15)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#f39c12',
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // --- 2. 月別棒グラフ (予約数のみ) ---
            const monthlyCtx = document.getElementById('monthlyBarChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Bookings',
                            data: @json($monthlyBookings),
                            backgroundColor: '#bdc3c7', 
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // --- 3. 時間帯別の予約分布 (Peak Hours) ---
            const hourlyCtx = document.getElementById('hourlyPeakChart');
            if (hourlyCtx) {
                const hourlyData = @json($hourlyStats);
                new Chart(hourlyCtx, {
                    type: 'line',
                    data: {
                        labels: Array.from({ length: 24 }, (_, i) => i + ':00'),
                        datasets: [{
                            label: 'Reservations',
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
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (context) => `予約件数: ${context.raw}件`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 },
                                grid: { color: '#f0f0f0' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 12
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection