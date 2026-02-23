@extends('layouts.staff')

@section('title', 'Analysis of Hotel')

@section('content')

    <style>
        /* 基本コンテナ */
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

        /* ヒートマップのデザイン */
        .heatmap-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .calendar-day-head {
            text-align: center;
            font-size: 0.7rem;
            font-weight: bold;
            color: #999;
            padding-bottom: 5px;
        }

        .heat-tile {
            aspect-ratio: 1/1;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .day-number {
            font-size: 0.7rem;
            font-weight: 800;
            color: rgba(0, 0, 0, 0.25);
        }

        /* ヒートマップの色階層 (Blue系) */
        .level-0 {
            background-color: #f8f9fa;
        }

        .level-1 {
            background-color: #d1e3f8;
        }

        .level-2 {
            background-color: #7da9d8;
        }

        .level-3 {
            background-color: #2c5282;
        }

        .level-2 .day-number,
        .level-3 .day-number {
            color: white;
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
        }
    </style>

    <div class="container py-4">
        <div class="row">
            <div class="col">
                <div class="row g-3 mb-4">
                    {{-- KPI --}}
                    {{-- Total Bookings --}}
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">TOTAL RESERVATIONS</p>
                            <h3 class="fw-bold">{{ $currentKpi ? number_format($currentKpi->total_bookings) : 0 }}</h3>
                            <span class="badge bg-light text-muted">Current Month</span>
                        </div>
                    </div>
                    {{-- Total Guests --}}
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">TOTAL GUESTS</p>
                            <h3 class="fw-bold text-primary">
                                {{ $currentKpi ? number_format($currentKpi->total_guests) : 0 }}</h3>
                            <span class="badge bg-light text-muted">Current Month</span>
                        </div>
                    </div>
                    {{-- Avg. Stay --}}
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">AVG. DINING TIME</p>
                            <h3 class="fw-bold text-success">
                                {{ $currentKpi ? number_format($currentKpi->avg_stay, 1) : '0.0' }}</h3>
                            <span class="badge bg-light text-muted">Per Table</span>
                        </div>
                    </div>

                    <div class="collapse" id="detailedAnalysis">
                        <div class="row">
                            {{-- KPI推移グラフ --}}
                            <div class="col-12 mb-4">
                                <div class="analysis-container shadow-sm">
                                    <h6 class="chart-title border-bottom pb-3">Monthly KPI Trends</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="kpiTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- 月次パフォーマンス表 --}}
                            <div class="col-12">
                                <div class="analysis-container shadow-sm">
                                    <h6 class="chart-title border-bottom pb-3">Monthly KPI Table (Yearly Overview)</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle text-center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start">Month</th>
                                                    <th>Bookings</th>
                                                    <th>Guests</th>
                                                    <th>Avg. Stay</th>
                                                    <th>Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                                    <tr class="{{ now()->month - 1 == $i ? 'table-primary' : '' }}">
                                                        {{-- 今月をハイライト --}}
                                                        <td class="text-start fw-bold">{{ $monthName }}</td>
                                                        <td>{{ number_format($monthlyBookings[$i]) }}</td>
                                                        <td>{{ number_format($monthlyGuests[$i]) }}</td>
                                                        <td>{{ number_format($monthlyAvgStay[$i], 1) }}</td>
                                                        <td class="fw-bold">₱{{ number_format($monthlyRevenue[$i]) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 詳細表示ボタン --}}
                <div class="text-center mb-4">
                    <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse"
                        data-bs-target="#detailedAnalysis" aria-expanded="false">
                        <i class="fa-solid fa-magnifying-glass-chart me-2"></i>Show Detailed Monthly Analysis
                    </button>
                </div>

                <div class="row mb-4">
                    {{-- 2. Daily Occupancy Heatmap --}}
                    <div class="col-md-5">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">
                                <i class="fa-solid fa-calendar-days me-2 text-primary"></i>Daily Occupancy
                                ({{ now()->format('F Y') }})
                            </h6>
                            <div class="heatmap-grid mt-3">
                                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                    <div class="calendar-day-head">{{ $dayName }}</div>
                                @endforeach

                                @php $firstDayOfMonth = now()->startOfMonth()->dayOfWeek; @endphp
                                @for ($i = 0; $i < $firstDayOfMonth; $i++)
                                    <div class="empty-tile"></div>
                                @endfor

                                @foreach ($heatmapData as $day => $count)
                                    <div class="heat-tile level-{{ $count >= 5 ? 3 : ($count >= 3 ? 2 : ($count >= 1 ? 1 : 0)) }}"
                                        data-bs-toggle="tooltip" title="{{ $day }}日: {{ $count }}件の滞在">
                                        <span class="day-number">{{ $day }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end mt-3 gap-2 align-items-center opacity-75">
                                <small class="text-muted small">Low</small>
                                <div class="heat-tile level-0" style="width:12px; height:12px;"></div>
                                <div class="heat-tile level-1" style="width:12px; height:12px;"></div>
                                <div class="heat-tile level-2" style="width:12px; height:12px;"></div>
                                <div class="heat-tile level-3" style="width:12px; height:12px;"></div>
                                <small class="text-muted small">High</small>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Monthly Mixed Chart (Bookings & Revenue) --}}
                    <div class="col-md-7">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">Monthly Performance</h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Room Type Insights --}}
                <div class="analysis-container shadow-sm rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type
                            Insights</h6>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active btn-sm" id="tab-month" data-bs-toggle="pill"
                                    data-bs-target="#pills-month" type="button">This Month</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link btn-sm" id="tab-year" data-bs-toggle="pill"
                                    data-bs-target="#pills-year" type="button">This Year</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="pills-month">
                            <div class="row">
                                <div class="col-md-6 text-center border-end">
                                    <span class="badge bg-light text-dark mb-3">Revenue Share</span>
                                    <div class="chart-wrapper"><canvas id="typeChartMonth"></canvas></div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <span class="badge bg-light text-dark mb-3">Booking Volume</span>
                                    <div class="chart-wrapper"><canvas id="typeBookingChartMonth"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-year">
                            <div class="row">
                                <div class="col-md-6 text-center border-end">
                                    <span class="badge bg-light text-dark mb-3">Yearly Revenue Share</span>
                                    <div class="chart-wrapper"><canvas id="typeChartYear"></canvas></div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <span class="badge bg-light text-dark mb-3">Yearly Booking Volume</span>
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
        // --- KPI Trends Chart (Bookings, Guests, Avg.Stay) ---
        const kpiCtx = document.getElementById('kpiTrendChart');
        if (kpiCtx) {
            new Chart(kpiCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'Bookings',
                            data: @json($monthlyBookings),
                            borderColor: '#7da9d8', // Blue
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.3,
                            yAxisID: 'y-count',
                        },
                        {
                            label: 'Guests',
                            data: @json($monthlyGuests),
                            borderColor: '#ffcc5c', // Yellow
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            tension: 0.3,
                            yAxisID: 'y-count',
                        },
                        {
                            label: 'Avg. Stay (Days)',
                            data: @json($monthlyAvgStay),
                            borderColor: '#96ceb4', // Green
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5], // 点線にして区別
                            tension: 0.3,
                            yAxisID: 'y-stay',
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
                        'y-count': {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Count (Bookings/Guests)'
                            }
                        },
                        'y-stay': {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false
                            },
                            title: {
                                display: true,
                                text: 'Days (Avg. Stay)'
                            }
                        }
                    }
                }
            });
        }

        // 詳細ボタンが押されて表示が完了した時に実行
        document.getElementById('detailedAnalysis').addEventListener('shown.bs.collapse', function() {
            // グラフのサイズを再計算させる
            if (charts['kpiTrendChart']) charts['kpiTrendChart'].resize();
            if (charts['barChart']) charts['barChart'].resize();
        });

        document.addEventListener('DOMContentLoaded', function() {
            let charts = {};

            // ドーナツグラフ生成共通関数
            const createDoughnut = (id, labels, data) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (charts[id]) charts[id].destroy();

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

            // --- 複合グラフ (Bookings & Revenue) ---
            const barCtx = document.getElementById('barChart');
            if (barCtx) {
                new Chart(barCtx, {
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                type: 'line',
                                label: 'Total Revenue',
                                data: @json($monthlyRevenue),
                                borderColor: '#ff6384',
                                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                yAxisID: 'y-revenue',
                                zIndex: 10
                            },
                            {
                                type: 'bar',
                                label: 'Bookings',
                                data: @json($monthlyBookings),
                                backgroundColor: '#ced6e0',
                                borderRadius: 4,
                                yAxisID: 'y-bookings'
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
                                },
                                ticks: {
                                    callback: (value) => '₱' + value.toLocaleString()
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

            // 初期描画
            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')), @json($typeStatsMonth->pluck('total_sales')));
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')), @json($typeBookingStatsMonth->pluck('booking_count')));

            // タブ切り替え時の再描画
            document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tabEl => {
                tabEl.addEventListener('shown.bs.tab', function() {
                    if (this.id === 'tab-year') {
                        createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name')),
                            @json($typeStatsYear->pluck('total_sales')));
                        createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name')),
                            @json($typeBookingStatsYear->pluck('booking_count')));
                    } else {
                        createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')),
                            @json($typeStatsMonth->pluck('total_sales')));
                        createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')),
                            @json($typeBookingStatsMonth->pluck('booking_count')));
                    }
                });
            });
        });
    </script>
@endsection
