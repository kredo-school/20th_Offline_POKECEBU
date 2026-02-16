@extends('layouts.staff')

@section('title', 'Analysis of Hotel')

@section('content')

    <style>
        .btn-sidebar {
            border: 1px solid #333;
            border-radius: 0;
            background-color: white;
            color: black;
            width: 100%;
            margin-bottom: -1px;
        }

        .btn-sidebar.active {
            background-color: #7da9d8;
            font-weight: bold;
        }

        .analysis-container {
            border: 1px solid #333;
            background: white;
            padding: 30px;
            margin-bottom: 20px;
        }

        .kpi-box {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            flex: 1;
            min-width: 200px;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .chart-title {
            font-size: 0.9rem;
            font-weight: bold;
            color: #555;
            margin-bottom: 15px;
        }
    </style>

    <div class="container py-4">
        <h1 class="mb-5 fw-bold">Analysis Hotel</h1>

        <div class="row">
            {{-- Main Content --}}
            <div class="col-md-12">

                {{-- KPI Section --}}
                <div class="analysis-container shadow-sm border-0 rounded-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fa-solid fa-chart-pie me-2"></i>Performance Summary
                    </h4>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                        <div class="kpi-box border-0 shadow-sm" style="background: #f8f9fa;">
                            <div class="text-muted small fw-bold text-uppercase ls-1">Total Revenue</div>
                            <div class="display-6 fw-bold text-dark">${{ number_format($kpi->sales) }}</div>
                            <div class="text-muted small mt-2">Current Total</div>
                        </div>

                        <div class="kpi-box border-0 shadow-sm" style="background: #f8f9fa;">
                            <div class="text-muted small fw-bold text-uppercase ls-1">Total Guests</div>
                            <div class="display-6 fw-bold text-primary">{{ number_format($kpi->customers) }}</div>
                            <div class="text-success small mt-2">
                                <i class="fa-solid fa-caret-up"></i> 12% vs last month
                            </div>
                        </div>

                        <div class="kpi-box border-0 shadow-sm" style="background: #f8f9fa;">
                            <div class="text-muted small fw-bold text-uppercase ls-1">Avg. Stay</div>
                            <div class="display-6 fw-bold text-success">{{ number_format($avgStay, 1) }}</div>
                            <div class="text-muted small mt-2 text-uppercase">Nights / Guest</div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12">
                    {{-- 第1セクション: 曜日別(Line) と ルームタイプ売上(Doughnut) --}}
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="analysis-container shadow-sm border-0 rounded-4 h-100 mb-0">
                                <h6 class="chart-title text-center"><i class="fa-solid fa-calendar-day me-1"></i>Bookings by
                                    Day of Week</h6>
                                <canvas id="dayOfWeekChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="analysis-container shadow-sm border-0 rounded-4 h-100 mb-0">
                                <h6 class="chart-title text-center"><i class="fa-solid fa-money-bill-wave me-1"></i>Revenue
                                    by Room Type</h6>
                                <canvas id="typeChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- 第2セクション: 月別(Bar) と ルームタイプ予約数(Doughnut) --}}
                    <div class="row">
                        <div class="col-md-7">
                            <div class="analysis-container shadow-sm border-0 rounded-4 h-100 mb-0">
                                <h6 class="chart-title text-center"><i class="fa-solid fa-chart-bar me-1"></i>Monthly
                                    Hotel Bookings ({{ now()->year }})</h6>
                                <div class="mx-auto" style="position: relative; height: 300px;">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="analysis-container shadow-sm border-0 rounded-4 h-100 mb-0">
                                <h6 class="chart-title text-center"><i class="fa-solid fa-list-check me-1"></i>Bookings
                                    by Room Type</h6>
                                <canvas id="typeBookingChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. 月別予約数 (Bar Chart)
            const ctxBar = document.getElementById('barChart');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Bookings',
                        data: @json($monthlyBookings),
                        backgroundColor: 'rgba(125, 169, 216, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 2. 曜日別予約 (Line Chart)
            const ctxLine = document.getElementById('dayOfWeekChart');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Reservations',
                        data: @json($dayOfWeekData),
                        borderColor: '#7da9d8',
                        backgroundColor: 'rgba(125, 169, 216, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#7da9d8'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // 3. ルームタイプ別売上 (Doughnut Chart)
            const ctxDoughnut = document.getElementById('typeChart');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: @json($typeLabels),
                    datasets: [{
                        data: @json($typeRevenue),
                        backgroundColor: ['#7da9d8', '#ffcc5c', '#96ceb4', '#ffeead', '#d9a7c7'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15
                            }
                        }
                    },
                    cutout: '70%' // 真ん中の穴のサイズ
                }
            });

            // 4. ルームタイプ別予約数 (Doughnut Chart) - 追加
            const ctxBookingDoughnut = document.getElementById('typeBookingChart');
            new Chart(ctxBookingDoughnut, {
                type: 'doughnut',
                data: {
                    labels: @json($typeBookingLabels), // Controllerから渡されたラベル
                    datasets: [{
                        data: @json($typeBookingCounts), // Controllerから渡された予約数
                        backgroundColor: ['#7da9d8', '#ffcc5c', '#96ceb4', '#ffeead', '#d9a7c7'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
@endsection
