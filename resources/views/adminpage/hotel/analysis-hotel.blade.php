@extends('layouts.admin')

@section('title', 'Admin Analysis of Hotel')

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
            background-color: #7da9d8;
            color: white;
            border-color: #7da9d8;
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
            height: 300px !important;
            width: 100%;
        }

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
            border-color: #7da9d8;
        }
    </style>

    <div class="container py-4">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-2">
                <div class="d-flex flex-column mb-4">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar active"><i
                            class="fa-solid fa-hotel me-2"></i>Hotel</a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar"><i
                            class="fa-solid fa-utensils me-2"></i>Restaurant</a>
                </div>
                <select class="form-select form-select-sm border-dark-subtle shadow-sm"
                    onchange="window.location.href=this.value">
                    <option value="{{ route('admin.analysis.hotel') }}" {{ is_null($hotelId) ? 'selected' : '' }}>All Hotels
                    </option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ route('admin.analysis.hotel', ['id' => $hotel->id]) }}"
                            {{ $hotelId == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Main --}}
            <div class="col-md-10">
                {{-- KPI Section --}}
                <div class="analysis-container shadow-sm">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Total Bookings</div>
                            <div class="h2 fw-bold text-dark">{{ number_format($kpi->total_bookings) }}</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Total Guests</div>
                            <div class="h2 fw-bold text-primary">{{ number_format($kpi->total_guests) }}</div>
                        </div>
                        <div class="kpi-box shadow-sm">
                            <div class="text-muted small fw-bold mb-1 text-uppercase">Avg. Stay</div>
                            <div class="h2 fw-bold text-success">{{ number_format($avgStay, 1) }}</div>
                            <div class="text-muted x-small">Nights per Booking</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    {{-- Daily Occupancy Trends (書き換え箇所: 折れ線グラフ) --}}
                    <div class="col-md-7">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-chart-line me-2 text-primary"></i>Daily Occupancy Trends
                                ({{ now()->format('F Y') }})
                            </h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="dailyOccupancyChart"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Monthly Performance --}}
                    <div class="col-md-5">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-calendar-check me-2 text-primary"></i>Monthly Performance
                            </h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Room Type Section --}}
                <div class="analysis-container shadow-sm rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type
                            Insights</h6>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active btn-sm" id="tab-month" data-bs-toggle="pill"
                                    data-bs-target="#pills-month" type="button" role="tab" aria-controls="pills-month"
                                    aria-selected="true">This Month</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link btn-sm" id="tab-year" data-bs-toggle="pill"
                                    data-bs-target="#pills-year" type="button" role="tab" aria-controls="pills-year"
                                    aria-selected="false">This Year</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content pt-3">
                        {{-- Month View --}}
                        <div class="tab-pane fade show active" id="pills-month" role="tabpanel" aria-labelledby="tab-month">
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

                        {{-- Year View --}}
                        <div class="tab-pane fade" id="pills-year" role="tabpanel" aria-labelledby="tab-year">
                            <div class="row">
                                <div class="col-md-6 text-center border-end">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Yearly Revenue Share</span>
                                    <div class="chart-wrapper"><canvas id="typeChartYear"></canvas></div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2">Yearly Booking Volume</span>
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

            let charts = {};

            // 共通ドーナツグラフ作成関数
            const createDoughnut = (id, labels, data) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (charts[id]) {
                    charts[id].destroy();
                }

                charts[id] = new Chart(el, {
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

            // --- 1. 日次稼働トレンド (折れ線グラフに書き換え) ---
            const dailyCtx = document.getElementById('dailyOccupancyChart');
            if (dailyCtx) {
                const dailyData = @json($heatmapData);
                new Chart(dailyCtx, {
                    type: 'line', // lineに変更
                    data: {
                        labels: Object.keys(dailyData).map(day => day + '日'),
                        datasets: [{
                            label: 'Active Stays',
                            data: Object.values(dailyData),
                            borderColor: '#7da9d8',
                            backgroundColor: 'rgba(125, 169, 216, 0.2)', // エリア塗りの色
                            fill: true, // 線の下を塗る
                            tension: 0.4, // 線の丸み
                            borderWidth: 3,
                            pointBackgroundColor: '#7da9d8',
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // --- 2. 月別複合グラフ (Bookings & Revenue) ---
            const barCtx = document.getElementById('barChart');
            if (barCtx) {
                new Chart(barCtx, {
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                // 売上 (折れ線グラフ)
                                type: 'line',
                                label: 'Total Revenue',
                                data: @json($monthlyRevenue), // 追加した変数
                                borderColor: '#ff6384',
                                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                yAxisID: 'y-revenue', // 右軸を使用
                                zIndex: 10
                            },
                            {
                                // 予約件数 (棒グラフ)
                                type: 'bar',
                                label: 'Bookings',
                                data: @json($monthlyBookings),
                                backgroundColor: '#ced6e0',
                                borderRadius: 4,
                                yAxisID: 'y-bookings', // 左軸を使用
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            // 左側の軸（予約数）
                            'y-bookings': {
                                type: 'linear',
                                position: 'left',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Bookings'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            // 右側の軸（売上）
                            'y-revenue': {
                                type: 'linear',
                                position: 'right',
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Revenue (₱)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }, // グリッド線が重ならないように設定
                                ticks: {
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // --- 3. 初期表示: Month タブ ---
            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')), @json($typeStatsMonth->pluck('total_sales')));
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')), @json($typeBookingStatsMonth->pluck('booking_count')));

            // --- 4. タブイベント ---
            const yearTabEl = document.getElementById('tab-year');
            const monthTabEl = document.getElementById('tab-month');

            if (yearTabEl) {
                yearTabEl.addEventListener('shown.bs.tab', function() {
                    createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name')),
                        @json($typeStatsYear->pluck('total_sales')));
                    createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name')),
                        @json($typeBookingStatsYear->pluck('booking_count')));
                });
            }

            if (monthTabEl) {
                monthTabEl.addEventListener('shown.bs.tab', function() {
                    createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')),
                        @json($typeStatsMonth->pluck('total_sales')));
                    createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')),
                        @json($typeBookingStatsMonth->pluck('booking_count')));
                });
            }
        });
    </script>
@endsection
