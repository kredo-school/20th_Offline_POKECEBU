@extends('layouts.admin')

@section('title', 'Admin Analysis of Hotel')

@section('content')

    <style>
        /* サイドバーのブラッシュアップ */
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

        .btn-sidebar:hover {
            background-color: #f8f9fa;
            border-color: #7da9d8;
        }

        .btn-sidebar.active {
            background-color: #7da9d8;
            color: white;
            border-color: #7da9d8;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(125, 169, 216, 0.3);
        }

        /* コンテナの統一感 */
        .analysis-container {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border: none;
            /* ボーダーを消してシャドウで浮かせる */
        }

        /* KPIボックスの強化 */
        .kpi-box {
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            flex: 1;
            min-width: 220px;
            transition: transform 0.2s;
            background: #ffffff;
            border: 1px solid #f0f0f0;
        }

        .kpi-box:hover {
            transform: translateY(-5px);
        }

        .ls-1 {
            letter-spacing: 1px;
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
            height: 300px !important;
            width: 100%;
            overflow: hidden;
        }

        /* タブのカスタマイズ */
        .nav-pills .nav-link {
            color: #7da9d8;
            border: 1px solid #7da9d8;
            margin-left: 5px;
            border-radius: 20px;
            padding: 5px 15px;
        }

        .nav-pills .nav-link.active {
            background-color: #7da9d8;
            color: white;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="fw-bold m-0">Hotel Analytics</h1>
            <span class="badge bg-light text-dark border p-2">
                <i class="fa-solid fa-calendar me-1"></i> {{ now()->format('M d, Y') }}
            </span>
        </div>

        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-2">
                <div class="d-flex flex-column" id="menuGroup">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar active">
                        <i class="fa-solid fa-hotel me-2"></i>Hotel
                    </a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar">
                        <i class="fa-solid fa-utensils me-2"></i>Restaurant
                    </a>
                </div>

                <select id="hotelSelect" class="form-select border-dark-subtle" onchange="window.location.href=this.value">
                    <option value="{{ route('admin.analysis.hotel') }}" {{ is_null($hotelId) ? 'selected' : '' }}>
                        All Hotels (Overall)
                    </option>

                    @foreach ($hotels as $hotel)
                        <option value="{{ route('admin.analysis.hotel', ['id' => $hotel->id]) }}"
                            {{ isset($hotelId) && $hotelId == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Main Content --}}
            <div class="col-md-10">
                {{-- KPI Section --}}
                <div class="analysis-container shadow-sm rounded-4">
                    <h5 class="fw-bold mb-4 text-secondary">Performance Summary</h5>
                    <div class="d-flex justify-content-center gap-4 flex-wrap">
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold text-uppercase ls-1 mb-1">Total Revenue</div>
                            <div class="h2 fw-bold text-dark">₱{{ number_format($kpi->sales) }}</div>
                            <div class="text-muted x-small mt-2">MTD Performance</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold text-uppercase ls-1 mb-1">Total Guests</div>
                            <div class="h2 fw-bold text-primary">{{ number_format($kpi->customers) }}</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold text-uppercase ls-1 mb-1">Avg. Stay</div>
                            <div class="h2 fw-bold text-success">{{ number_format($avgStay, 1) }}</div>
                            <div class="text-muted small mt-2">Nights / Guest</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="analysis-container shadow-sm rounded-4 h-100">
                            <h6 class="chart-title"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>Weekly Booking
                                Trends</h6>
                            <div class="chart-wrapper"><canvas id="dayOfWeekChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="analysis-container shadow-sm rounded-4 h-100">
                            <h6 class="chart-title"><i class="fa-solid fa-chart-bar me-2 text-primary"></i>Monthly
                                Performance</h6>
                            <div class="chart-wrapper"><canvas id="barChart"></canvas></div>
                        </div>
                    </div>
                </div>

                {{-- Room Type Section --}}
                <div class="analysis-container shadow-sm rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type
                            Insights</h6>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item"><button class="nav-link active btn-sm" data-bs-toggle="pill"
                                    data-bs-target="#pills-month" type="button">This Month</button></li>
                            <li class="nav-item"><button class="nav-link btn-sm" data-bs-toggle="pill"
                                    data-bs-target="#pills-year" type="button">This Year</button></li>
                        </ul>
                    </div>

                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="pills-month">
                            <div class="row">
                                <div class="col-md-6 text-center border-end">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Revenue Share</span>
                                    <div class="chart-wrapper"><canvas id="typeChartMonth"></canvas></div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Booking Volume</span>
                                    <div class="chart-wrapper"><canvas id="typeBookingChartMonth"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-year">
                            <div class="row">
                                <div class="col-md-6 text-center border-end">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Revenue Share (Year)</span>
                                    <div class="chart-wrapper"><canvas id="typeChartYear"></canvas></div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Booking Volume (Year)</span>
                                    <div class="chart-wrapper"><canvas id="typeBookingChartYear"></canvas></div>
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
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                }
            };

            // 1. Bar Chart
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Bookings',
                        data: @json($monthlyBookings),
                        backgroundColor: '#7da9d8'
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // 2. Line Chart
            new Chart(document.getElementById('dayOfWeekChart'), {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                            label: 'This Week',
                            data: @json($dayOfWeekData['thisWeek']),
                            borderColor: '#7da9d8',
                            fill: true,
                            backgroundColor: 'rgba(125,169,216,0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Past Avg',
                            data: @json($dayOfWeekData['average']),
                            borderColor: '#b2bec3',
                            borderDash: [5, 5],
                            tension: 0.4
                        }
                    ]
                },
                options: commonOptions
            });

            const createDoughnut = (id, labels, data) => {
                new Chart(document.getElementById(id), {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: ['#7da9d8', '#ffcc5c', '#96ceb4', '#ffeead',
                                '#d9a7c7'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = parseFloat(context.raw);
                                        const total = context.dataset.data.reduce((acc, curr) => {
                                            return acc + parseFloat(curr);
                                        }, 0);
                                        const percentage = total > 0 ? ((value / total) * 100)
                                            .toFixed(1) : 0;
                                        return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            };

            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')), @json($typeStatsMonth->pluck('total_sales')));
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')), @json($typeBookingStatsMonth->pluck('booking_count')));
            createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name')), @json($typeStatsYear->pluck('total_sales')));
            createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name')), @json($typeBookingStatsYear->pluck('booking_count')));
        });
    </script>
@endsection
