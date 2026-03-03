@extends('layouts.staff')
 
@section('title', 'Analysis of Restaurant')
 
@section('content')

    <style>
        .analysis-container { background: white; padding: 25px; margin-bottom: 25px; border-radius: 15px; }
        .kpi-box { border-radius: 15px; padding: 25px; text-align: center; flex: 1; min-width: 200px; background: #ffffff; border: 1px solid #f0f0f0; }
        .chart-title { font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; }
        .chart-wrapper { position: relative; height: 300px !important; width: 100%; }
        .btn-detail { border-radius: 20px; padding: 8px 25px; font-weight: bold; }

        /* ヒートマップのデザイン */
        .heatmap-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
        .calendar-day-head { text-align: center; font-size: 0.7rem; font-weight: bold; color: #999; padding-bottom: 5px; }
        .heat-tile { aspect-ratio: 1/1; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid #f0f0f0; position: relative; transition: transform 0.2s; }
        .heat-tile:hover { transform: scale(1.05); }
        .day-number { font-size: 0.7rem; font-weight: 800; color: rgba(0, 0, 0, 0.25); }
        .empty-tile { aspect-ratio: 1/1; }

        .level-0 { background-color: #f8f9fa; }
        .level-1 { background-color: #fff3e0; }
        .level-2 { background-color: #ffcc80; }
        .level-3 { background-color: #ef6c00; } 
        .level-3 .day-number { color: white; }

        .btn-month-nav { border: 1px solid #f0f0f0; background: white; color: #666; }
        .btn-month-nav:hover { background: #f8f9fa; }
    </style>

    <div class="container py-4">
        {{-- KPI Section --}}
        <div class="analysis-container shadow-sm">
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <div class="kpi-box shadow-sm border-0">
                    <div class="text-muted small fw-bold mb-1 text-uppercase">Total Reservations</div>
                    <div class="h2 fw-bold text-dark">{{ number_format($kpi->total_bookings ?? 0) }}</div>
                    <div class="text-muted x-small">Current Month</div>
                </div>
                <div class="kpi-box shadow-sm border-0">
                    <div class="text-muted small fw-bold mb-1 text-uppercase">Total Guests</div>
                    <div class="h2 fw-bold text-warning">{{ number_format($kpi->total_guests ?? 0) }}</div>
                    <div class="text-muted x-small">Current Month</div>
                </div>
                <div class="kpi-box shadow-sm border-0">
                    <div class="text-muted small fw-bold mb-1 text-uppercase">Avg. Dining Time</div>
                    <div class="h2 fw-bold text-success">{{ number_format($avgStayTime ?? 0) }} min</div>
                    <div class="text-muted x-small">Per Table</div>
                </div>
            </div>
        </div>

        {{-- 詳細表示ボタン --}}
        <div class="text-center mb-4">
            <button class="btn btn-outline-warning btn-detail shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#detailedAnalysis">
                <i class="fa-solid fa-chart-pie me-2"></i>Show Yearly Detailed Analysis
            </button>
        </div>

        {{-- 詳細エリア --}}
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
                                        <tr class="{{ (now()->month - 1) == $i ? 'table-warning' : '' }}">
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
            {{-- ヒートマップ: 月切り替え機能付き --}}
            <div class="col-md-5">
                <div class="analysis-container shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <h6 class="chart-title m-0">
                            <i class="fa-solid fa-calendar-days me-2 text-warning"></i>Booking Heatmap
                        </h6>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-month-nav" id="prevMonth"><i class="fa-solid fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-sm btn-white border-top border-bottom fw-bold" id="currentMonthLabel" style="min-width: 110px;"></button>
                            <button type="button" class="btn btn-sm btn-month-nav" id="nextMonth"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="heatmap-grid" id="heatmapGrid">
                        {{-- JSで生成 --}}
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
            // --- KPI Trend Chart ---
            const kpiCtx = document.getElementById('kpiTrendChart');
            if (kpiCtx) {
                new Chart(kpiCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            { label: 'Bookings', data: @json($monthlyBookings), borderColor: '#ffcc5c', tension: 0.3, fill: false },
                            { label: 'Guests', data: @json($monthlyGuests), borderColor: '#96ceb4', tension: 0.3, fill: false }
                        ]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }

            // --- Hourly Chart ---
            const hourlyCtx = document.getElementById('hourlyChart');
            if (hourlyCtx) {
                new Chart(hourlyCtx, {
                    type: 'bar',
                    data: {
                        labels: @json(array_keys($hourlyStats ?? [])),
                        datasets: [{
                            label: 'Reservations',
                            data: @json(array_values($hourlyStats ?? [])),
                            backgroundColor: '#ffcc5c',
                            borderRadius: 5
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }

            // --- Dynamic Heatmap Logic ---
            const allDailyData = @json($allDailyData);
            let viewDate = new Date(); // 表示基準日
            const grid = document.getElementById('heatmapGrid');
            const label = document.getElementById('currentMonthLabel');

            function renderHeatmap(date) {
                grid.innerHTML = '';
                const year = date.getFullYear();
                const month = date.getMonth();

                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                label.innerText = `${monthNames[month]} ${year}`;

                // Header
                ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(d => {
                    const head = document.createElement('div');
                    head.className = 'calendar-day-head';
                    head.innerText = d;
                    grid.appendChild(head);
                });

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Empty slots
                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    empty.className = 'empty-tile';
                    grid.appendChild(empty);
                }

                // Day tiles
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const count = allDailyData[dateStr] || 0;
                    
                    let level = 0;
                    if (count >= 10) level = 3;
                    else if (count >= 5) level = 2;
                    else if (count >= 1) level = 1;

                    const tile = document.createElement('div');
                    tile.className = `heat-tile level-${level}`;
                    tile.innerHTML = `<span class="day-number">${day}</span>`;
                    tile.setAttribute('data-bs-toggle', 'tooltip');
                    tile.setAttribute('title', `${dateStr}: ${count} reservations`);
                    
                    grid.appendChild(tile);
                }

                // Re-init tooltips
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

            // Initial Render
            renderHeatmap(viewDate);
        });
    </script>
@endsection