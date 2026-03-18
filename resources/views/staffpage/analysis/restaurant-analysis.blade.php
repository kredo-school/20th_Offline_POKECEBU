@extends('layouts.staff')

@section('title', 'Analysis of Restaurant')

@section('content')

    <div class="container py-4">
        {{-- KPI Section --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <div class="kpi-box shadow-sm border-0">
                <div class="text-muted small fw-bold mb-1 text-uppercase">Total Reservations</div>
                <div class="h2 fw-bold text-dark">{{ number_format($kpi->total_bookings ?? 0) }}</div>
                <div class="text-muted small">Current Month</div>
            </div>
            <div class="kpi-box shadow-sm border-0">
                <div class="text-muted small fw-bold mb-1 text-uppercase">Total Guests</div>
                <div class="h2 fw-bold text-warning">{{ number_format($kpi->total_guests ?? 0) }}</div>
                <div class="text-muted small">Current Month</div>
            </div>
            <div class="kpi-box shadow-sm border-0">
                <div class="text-muted small fw-bold mb-1 text-uppercase">Avg. Dining Time</div>
                <div class="h2 fw-bold text-success">{{ number_format($avgStayTime ?? 0) }} min</div>
                <div class="text-muted small">Per Table</div>
            </div>
        </div>

        {{-- 詳細表示ボタン --}}
        <div class="text-center m-5">
            <button class="btn btn-outline-warning btn-detail shadow-sm" type="button" data-bs-toggle="collapse"
                data-bs-target="#detailedAnalysis" aria-expanded="false">
                <i class="fa-solid fa-chart-pie me-2"></i>Show Yearly Detailed Analysis
            </button>
        </div>

        {{-- 詳細エリア (折れ線グラフとテーブル) --}}
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
                <div class="col-12 mb-4">
                    <div class="analysis-container shadow-sm">
                        <h6 class="chart-title border-bottom pb-3">Monthly KPI Table</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start ps-4">Month</th>
                                        <th>Bookings</th>
                                        <th>Guests</th>
                                        <th>Avg. Stay (min)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                        <tr class="{{ now()->month - 1 == $i ? 'table-warning' : '' }}">
                                            <td class="text-start ps-4 fw-bold">{{ $monthName }}</td>
                                            <td>{{ number_format($monthlyBookings[$i] ?? 0) }}</td>
                                            <td>{{ number_format($monthlyGuests[$i] ?? 0) }}</td>
                                            <td>{{ number_format($monthlyAvgStay[$i] ?? 0, 1) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            {{-- ヒートマップ --}}
            <div class="col-md-5">
                <div class="analysis-container shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <h6 class="chart-title m-0">
                            <i class="fa-solid fa-calendar-days me-2 text-warning"></i>Booking Heatmap
                            <a href="{{ route('restaurant.calendar') }}" class="btn btn-sm btn-outline-primary ms-2">View
                                Calendar</a>
                        </h6>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-month-nav" id="prevMonth"><i
                                    class="fa-solid fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-sm btn-white border-top border-bottom fw-bold"
                                id="currentMonthLabel" style="min-width: 110px;"></button>
                            <button type="button" class="btn btn-sm btn-month-nav" id="nextMonth"><i
                                    class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="heatmap-grid" id="heatmapGrid"></div>

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

            {{-- 混雑時間帯グラフ --}}
            <div class="col-md-7">
                <div class="analysis-container shadow-sm h-100">
                    <h6 class="chart-title border-bottom pb-3">Hourly Busy Levels</h6>
                    <div class="chart-wrapper mt-3">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 数値変換用ヘルパー (文字列を数値に、nullを0にする)
            const parseData = (data) => Array.isArray(data) ? data.map(v => Number(v || 0)) : [];
            let kpiChart, hourlyChart;

            // --- 1. KPI Trend Chart ---
            const kpiCtx = document.getElementById('kpiTrendChart');
            if (kpiCtx) {
                kpiChart = new Chart(kpiCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov', 'Dec'
                        ],
                        datasets: [{
                                label: 'Bookings',
                                data: parseData(@json($monthlyBookings)),
                                borderColor: '#ffcc5c',
                                backgroundColor: 'rgba(255, 204, 92, 0.2)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Guests',
                                data: parseData(@json($monthlyGuests)),
                                borderColor: '#96ceb4',
                                backgroundColor: 'rgba(150, 206, 180, 0.2)',
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (context) =>
                                        ` ${context.dataset.label}: ${Number(context.parsed.y).toLocaleString()}`
                                }
                            }
                        }
                    }
                });
            }

            // --- 2. Hourly Chart ---
            const hourlyCtx = document.getElementById('hourlyChart');
            if (hourlyCtx) {
                const hourlyData = @json($hourlyStats ?? []);
                hourlyChart = new Chart(hourlyCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(hourlyData),
                        datasets: [{
                            label: 'Reservations',
                            data: parseData(Object.values(hourlyData)),
                            backgroundColor: '#ffcc5c',
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (context) =>
                                        ` Reservations: ${Number(context.parsed.y).toLocaleString()}`
                                }
                            }
                        }
                    }
                });
            }

            // --- 3. Dynamic Heatmap Logic ---
            const allDailyData = @json($allDailyData);
            let viewDate = new Date();
            const grid = document.getElementById('heatmapGrid');
            const label = document.getElementById('currentMonthLabel');

            function renderHeatmap(date) {
                grid.innerHTML = '';
                const year = date.getFullYear();
                const month = date.getMonth();
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];
                label.innerText = `${monthNames[month]} ${year}`;

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
                    const count = Number(allDailyData[dateStr] || 0);

                    let level = 0;
                    if (count >= 10) level = 3;
                    else if (count >= 5) level = 2;
                    else if (count >= 1) level = 1;

                    const tile = document.createElement('div');
                    // 'cursor-pointer' を追加して、クリック可能であることを示します
                    tile.className = `heat-tile level-${level} cursor-pointer`;
                    tile.innerHTML = `<span class="day-number">${day}</span>`;
                    tile.setAttribute('data-bs-toggle', 'tooltip');
                    tile.setAttribute('title', `${dateStr}: ${count} reservations`);

                    // --- ここから追加: クリックイベント ---
                    tile.addEventListener('click', () => {
                        // Laravelのルートを生成（プレースホルダ :date を使用）
                        const urlPattern =
                            "{{ route('restaurant.reservations.date', ['date' => ':date']) }}";
                        // :date を JavaScript の dateStr に置換して遷移
                        window.location.href = urlPattern.replace(':date', dateStr);
                    });
                    // --- ここまで追加 ---

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
        });
    </script>
@endsection
