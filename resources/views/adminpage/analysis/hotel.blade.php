@extends('layouts.admin')

@section('title', 'Admin Analysis of Hotel')

@section('content')

    <div class="analysis-wrapper">
        <div class="container-fluid">
            <div class="row g-4">
                {{-- 1. Sidebar --}}
                <div class="col-lg-2">
                    <div class="sticky-top" style="top: 20px;">
                        <h5 class="fw-bold mb-4 ps-2">Admin Console</h5>
                        <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar active shadow-sm">
                            <i class="fa-solid fa-hotel me-2"></i>Hotel
                        </a>
                        <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar shadow-sm">
                            <i class="fa-solid fa-utensils me-2"></i>Restaurant
                        </a>
                        <a href="{{ route('admin.analysis.user') }}" class="btn btn-sidebar shadow-sm">
                            <i class="fa-solid fa-users-gear me-2"></i>User Insights
                        </a>

                        <div class="mt-4 p-2">
                            <label class="small fw-bold text-muted mb-2 d-block">Hotel Selector</label>
                            <select class="form-select border-0 shadow-sm rounded-3 py-2"
                                onchange="window.location.href=this.value">
                                <option value="{{ route('admin.analysis.hotel') }}"
                                    {{ is_null($hotelId) ? 'selected' : '' }}>All Hotels</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ route('admin.analysis.hotel', ['id' => $hotel->id]) }}"
                                        {{ $hotelId == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 2. Main Content --}}
                <div class="col-lg-10">
                    <div class="row g-4"> {{-- カード同士の隙間を一定にする --}}
                        <div class="col-md-4">
                            <div class="kpi-box border-start border-dark border-5">
                                <p class="text-muted small fw-bold mb-1">TOTAL RESERVATIONS</p>
                                <h2 class="fw-black m-0 text-dark">{{ number_format($currentKpi->total_bookings ?? 0) }}
                                </h2>
                                <span class="badge bg-light text-muted mt-2 border">Current Month</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="kpi-box border-start border-primary border-5">
                                <p class="text-primary small fw-bold mb-1">TOTAL GUESTS</p>
                                <h2 class="fw-black text-primary m-0">{{ number_format($currentKpi->total_guests ?? 0) }}
                                </h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary mt-2">Current Month</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="kpi-box border-start border-success border-5">
                                <p class="text-success small fw-bold mb-1">AVG. STAY</p>
                                <h2 class="fw-black text-success m-0">{{ number_format($currentKpi->avg_stay ?? 0, 1) }}d
                                </h2>
                                <span class="badge bg-success bg-opacity-10 text-success mt-2">Per Booking</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-5">
                        <button class="btn btn-dark rounded-pill px-5 shadow-sm fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#detailedTable">
                            <i class="fa-solid fa-table me-2"></i>Show Full Year Report
                        </button>
                    </div>

                    <div class="collapse mb-5" id="detailedTable">
                        <div class="analysis-card p-0 overflow-hidden shadow-sm border-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start ps-4 py-3">Month</th>
                                            <th>Bookings</th>
                                            <th>Guests</th>
                                            <th class="text-end pe-4 py-3">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                            <tr class="{{ now()->month - 1 == $i ? 'table-primary bg-opacity-10' : '' }}">
                                                <td class="text-start ps-4 fw-bold text-dark">{{ $monthName }}</td>
                                                <td>{{ number_format($monthlyBookings[$i] ?? 0) }}</td>
                                                <td>{{ number_format($monthlyGuests[$i] ?? 0) }}</td>
                                                <td class="text-end pe-4 fw-bold">
                                                    ₱{{ number_format($monthlyRevenue[$i] ?? 0) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="analysis-card shadow-sm">
                        <h6 class="chart-title border-bottom pb-3"><i
                                class="fa-solid fa-chart-line me-2 text-primary"></i>Monthly Performance Trends (All Months)
                        </h6>
                        <div class="chart-wrapper mt-3">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>

                    <div class="analysis-card shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type
                                Insights</h6>
                            <ul class="nav nav-pills nav-pills-custom" id="pills-tab">
                                <li class="nav-item">
                                    <button class="nav-link active" id="tab-month" data-bs-toggle="pill"
                                        data-bs-target="#pills-month">This Month</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="tab-year" data-bs-toggle="pill"
                                        data-bs-target="#pills-year">This Year</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-month">
                                <div class="row g-4 text-center">
                                    <div class="col-md-6 border-end">
                                        <span class="badge bg-light text-dark mb-3">Revenue Share</span>
                                        <div class="chart-wrapper"><canvas id="typeChartMonth"></canvas></div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="badge bg-light text-dark mb-3">Booking Volume</span>
                                        <div class="chart-wrapper"><canvas id="typeBookingChartMonth"></canvas></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-year">
                                <div class="row g-4 text-center">
                                    <div class="col-md-6 border-end">
                                        <span class="badge bg-light text-dark mb-3">Revenue Share (Annual)</span>
                                        <div class="chart-wrapper"><canvas id="typeChartYear"></canvas></div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="badge bg-light text-dark mb-3">Booking Volume (Annual)</span>
                                        <div class="chart-wrapper"><canvas id="typeBookingChartYear"></canvas></div>
                                    </div>
                                </div>
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
            const monthlyBookings = @json($monthlyBookings);
            const monthlyRevenue = @json($monthlyRevenue);
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // 1. Mixed Bar/Line Chart
            new Chart(document.getElementById('barChart'), {
                data: {
                    labels: labels,
                    datasets: [{
                            type: 'line',
                            label: 'Revenue (₱)',
                            data: monthlyRevenue,
                            borderColor: '#3b82f6',
                            tension: 0.4,
                            yAxisID: 'y1'
                        },
                        {
                            type: 'bar',
                            label: 'Bookings',
                            data: monthlyBookings,
                            backgroundColor: '#e2e8f0',
                            borderRadius: 5,
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Bookings'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Revenue (₱)'
                            }
                        }
                    }
                }
            });

            // 2. Room Type Doughnut Charts
            const createDoughnut = (id, labels, data) => {
                const ctx = document.getElementById(id);
                if (!ctx) return;
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                                '#8b5cf6'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12
                                }
                            }
                        }
                    }
                });
            };

            // 初期表示 (Month)
            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')), @json($typeStatsMonth->pluck('total_sales')));
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')), @json($typeBookingStatsMonth->pluck('booking_count')));

            // タブ切り替え時の描画 (Year)
            document.getElementById('tab-year').addEventListener('shown.bs.tab', function() {
                createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name')), @json($typeStatsYear->pluck('total_sales')));
                createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name')),
                    @json($typeBookingStatsYear->pluck('booking_count')));
            }, {
                once: true
            });
        });
    </script>
@endsection
