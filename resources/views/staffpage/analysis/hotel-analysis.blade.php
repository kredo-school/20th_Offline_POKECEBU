@extends('layouts.staff')

@section('title', 'Analysis of Hotel')

@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col">
                <div class="row g-3 mb-4">
                    {{-- KPI Cards --}}
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">TOTAL RESERVATIONS</p>
                            <h3 class="fw-bold">{{ $currentKpi ? number_format($currentKpi->total_bookings) : 0 }}</h3>
                            <span class="badge bg-light text-muted">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">TOTAL GUESTS</p>
                            <h3 class="fw-bold text-primary">
                                {{ $currentKpi ? number_format($currentKpi->total_guests) : 0 }}</h3>
                            <span class="badge bg-light text-muted">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm border-0">
                            <p class="text-muted small mb-1">AVG. STAY TIME</p>
                            <h3 class="fw-bold text-success">
                                {{ $currentKpi ? number_format($currentKpi->avg_stay, 1) : '0.0' }}</h3>
                            <span class="badge bg-light text-muted">Days</span>
                        </div>
                    </div>

                    <div class="text-center m-5">
                        <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#detailedAnalysis">
                            <i class="fa-solid fa-magnifying-glass-chart me-2"></i>Show Detailed Monthly Analysis
                        </button>
                    </div>

                    {{-- Yearly Detailed Collapse --}}
                    <div class="collapse" id="detailedAnalysis">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="analysis-container shadow-sm">
                                    <h6 class="chart-title border-bottom pb-3">Monthly KPI Trends</h6>
                                    <div class="chart-wrapper">
                                        <canvas id="kpiTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="analysis-container shadow-sm">
                                    <h6 class="chart-title border-bottom pb-3">Monthly KPI Table</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle text-center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-start ps-3">Month</th>
                                                    <th>Bookings</th>
                                                    <th>Guests</th>
                                                    <th>Avg. Stay</th>
                                                    <th>Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                                    <tr class="{{ now()->month - 1 == $i ? 'table-primary' : '' }}">
                                                        <td class="text-start ps-3 fw-bold">{{ $monthName }}</td>
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

                <div class="row mb-4">
                    {{-- Daily Occupancy Heatmap --}}
                    <div class="col-md-5">
                        <div class="analysis-container shadow-sm h-100">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                <h6 class="chart-title m-0">
                                    <i class="fa-solid fa-calendar-days me-2 text-primary"></i>Daily Occupancy
                                    <a href="{{ route('hotel.calendar') }}" class="btn btn-sm btn-outline-primary ms-2">View
                                        Calendar</a>
                                </h6>
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-sm btn-month-nav" id="prevMonth"><i
                                            class="fa-solid fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-sm btn-white border-top border-bottom fw-bold"
                                        id="currentMonthLabel" style="min-width: 110px;"></button>
                                    <button type="button" class="btn btn-sm btn-month-nav" id="nextMonth"><i
                                            class="fa-solid fa-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="heatmap-grid" id="heatmapGrid"></div>
                        </div>
                    </div>

                    {{-- Monthly Mixed Chart --}}
                    <div class="col-md-7">
                        <div class="analysis-container shadow-sm h-100">
                            <h6 class="chart-title border-bottom pb-3">Monthly Performance</h6>
                            <div class="chart-wrapper mt-3">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Room Type Insights --}}
                <div class="analysis-container shadow-sm rounded-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type
                            Insights</h6>
                        <ul class="nav nav-pills" id="pills-tab">
                            <li class="nav-item">
                                <button class="nav-link active btn-sm" id="tab-month" data-bs-toggle="pill"
                                    data-bs-target="#pills-month">This Month</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link btn-sm" id="tab-year" data-bs-toggle="pill"
                                    data-bs-target="#pills-year">This Year</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // 文字列を数値に確実に変換するヘルパー
            const parseNumericData = (data) => Array.isArray(data) ? data.map(v => Number(v || 0)) : [];
            let charts = {};

            // --- 1. KPI Trends Chart ---
            const kpiCtx = document.getElementById('kpiTrendChart');
            if (kpiCtx) {
                charts['kpiTrendChart'] = new Chart(kpiCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                label: 'Bookings',
                                data: parseNumericData(@json($monthlyBookings)),
                                borderColor: '#7da9d8',
                                tension: 0.3,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Guests',
                                data: parseNumericData(@json($monthlyGuests)),
                                borderColor: '#ffcc5c',
                                tension: 0.3,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Avg. Stay',
                                data: parseNumericData(@json($monthlyAvgStay)),
                                borderColor: '#96ceb4',
                                borderDash: [5, 5],
                                tension: 0.3,
                                yAxisID: 'y-stay'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            'y-stay': {
                                position: 'right',
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // --- 2. Bar Chart (Revenue & Bookings) ---
            const barCtx = document.getElementById('barChart');
            if (barCtx) {
                charts['barChart'] = new Chart(barCtx, {
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                type: 'line',
                                label: 'Revenue',
                                data: parseNumericData(@json($monthlyRevenue)),
                                borderColor: '#ff6384',
                                yAxisID: 'y-revenue',
                                tension: 0.4
                            },
                            {
                                type: 'bar',
                                label: 'Bookings',
                                data: parseNumericData(@json($monthlyBookings)),
                                backgroundColor: '#ced6e0',
                                yAxisID: 'y-bookings',
                                borderRadius: 5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            'y-bookings': {
                                beginAtZero: true,
                                position: 'left'
                            },
                            'y-revenue': {
                                beginAtZero: true,
                                position: 'right',
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // --- 3. Doughnut Charts (Admin形式を移植) ---
            const createDoughnut = (id, labels, data, unit = '') => {
                const el = document.getElementById(id);
                if (!el) return;
                if (charts[id]) charts[id].destroy();

                charts[id] = new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: parseNumericData(data),
                            backgroundColor: ['#7da9d8', '#ffcc5c', '#96ceb4', '#ffeead',
                                '#d9a7c7'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
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
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const val = context.parsed || 0;
                                        const sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const pct = sum > 0 ? (val * 100 / sum).toFixed(1) : 0;
                                        return ` ${context.label}: ${val.toLocaleString()}${unit} (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            };

            // 初期化
            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name')), @json($typeStatsMonth->pluck('total_sales')), '₱');
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name')), @json($typeBookingStatsMonth->pluck('booking_count')),
                '件');

            // タブ切り替えイベント
            document.getElementById('tab-year').addEventListener('shown.bs.tab', function() {
                createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name')), @json($typeStatsYear->pluck('total_sales')),
                    '₱');
                createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name')),
                    @json($typeBookingStatsYear->pluck('booking_count')), '件');
            });

            // --- 4. Heatmap ---
            const allDailyData = @json($allDailyData);
            let viewDate = new Date();

            function renderHeatmap(date) {
                const grid = document.getElementById('heatmapGrid');
                grid.innerHTML = '';
                const year = date.getFullYear();
                const month = date.getMonth();
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];
                document.getElementById('currentMonthLabel').innerText = `${monthNames[month]} ${year}`;

                ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(d => {
                    const head = document.createElement('div');
                    head.className = 'calendar-day-head';
                    head.innerText = d;
                    grid.appendChild(head);
                });

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    empty.className = 'empty-tile';
                    grid.appendChild(empty);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const count = allDailyData[dateStr] || 0;
                    let level = count >= 5 ? 3 : (count >= 3 ? 2 : (count >= 1 ? 1 : 0));

                    const tile = document.createElement('div');
                    // 'cursor-pointer' クラスを追加して、クリックできることを示します
                    tile.className = `heat-tile level-${level} cursor-pointer`;
                    tile.innerHTML = `<span class="day-number">${day}</span>`;

                    tile.setAttribute('data-bs-toggle', 'tooltip');
                    tile.setAttribute('title', `${dateStr}: ${count} stays`);

                    // --- ここを修正: /reservations/{date} への遷移 ---
                    tile.addEventListener('click', () => {
                        // Laravelのルート定義からベースURLを取得し、日付を結合します
                        const baseUrl = "{{ route('hotel.reservations.date', ['date' => ':date']) }}";
                        window.location.href = baseUrl.replace(':date', dateStr);
                    });

                    grid.appendChild(tile);
                }
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
            }

            document.getElementById('prevMonth').addEventListener('click', () => {
                viewDate.setMonth(viewDate.getMonth() - 1);
                renderHeatmap(viewDate);
            });
            document.getElementById('nextMonth').addEventListener('click', () => {
                viewDate.setMonth(viewDate.getMonth() + 1);
                renderHeatmap(viewDate);
            });
            renderHeatmap(viewDate);

            // Collapseリサイズ対応
            document.getElementById('detailedAnalysis').addEventListener('shown.bs.collapse', () => {
                if (charts['kpiTrendChart']) charts['kpiTrendChart'].resize();
            });
        });
    </script>
@endsection
