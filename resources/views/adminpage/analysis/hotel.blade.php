@extends('layouts.admin')

@section('title', 'Admin Analysis of Hotel')

@section('content')

    <div class="analysis-wrapper">
        <div class="row g-5"> {{-- g-5 で左右の隙間を拡大 --}}
            
            {{-- 1. Sidebar (左側) --}}
            <div class="col-lg-2">
                <div class="d-flex flex-column mb-4">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar active">
                        <i class="fa-solid fa-hotel me-2"></i>Hotel
                    </a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar">
                        <i class="fa-solid fa-utensils me-2"></i>Restaurant
                    </a>
                </div>
                
                <div class="mt-4">
                    <label class="small fw-bold text-muted mb-2 ms-1">Hotel Selector</label>
                    <select class="form-select border-0 shadow-sm rounded-3" onchange="window.location.href=this.value">
                        <option value="{{ route('admin.analysis.hotel') }}" {{ is_null($hotelId) ? 'selected' : '' }}>All Hotels</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ route('admin.analysis.hotel', ['id' => $hotel->id]) }}" {{ $hotelId == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 2. Main Content (右側) --}}
            <div class="col-lg-10">
                
                {{-- KPI Section --}}
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2">TOTAL RESERVATIONS</p>
                            <h3 class="fw-extrabold m-0">{{ number_format($currentKpi->total_bookings ?? 0) }}</h3>
                            <span class="badge bg-light text-muted mt-2">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2 text-primary">TOTAL GUESTS</p>
                            <h3 class="fw-extrabold text-primary m-0">{{ number_format($currentKpi->total_guests ?? 0) }}</h3>
                            <span class="badge bg-light text-muted mt-2">Current Month</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kpi-box shadow-sm">
                            <p class="text-muted small fw-bold mb-2 text-success">AVG. STAY</p>
                            <h3 class="fw-extrabold text-success m-0">{{ number_format($currentKpi->avg_stay ?? 0, 1) }}d</h3>
                            <span class="badge bg-light text-muted mt-2">Per Booking</span>
                        </div>
                    </div>
                </div>

                {{-- 詳細表示ボタン --}}
                <div class="text-center mb-5">
                    <button class="btn btn-outline-primary rounded-pill px-5 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#detailedAnalysis">
                        <i class="fa-solid fa-magnifying-glass-chart me-2"></i>Show Detailed Monthly Report
                    </button>
                </div>

                <div class="collapse mb-4" id="detailedAnalysis">
                    <div class="analysis-card">
                        <h6 class="chart-title border-bottom pb-3">Monthly Performance Trends</h6>
                        <div class="chart-wrapper">
                            <canvas id="kpiTrendChart"></canvas>
                        </div>
                    </div>

                    <div class="analysis-card p-0 overflow-hidden shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start ps-4">Month</th>
                                        <th>Bookings</th>
                                        <th>Guests</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $i => $monthName)
                                        <tr class="{{ now()->month - 1 == $i ? 'table-primary' : '' }}">
                                            <td class="text-start ps-4 fw-bold">{{ $monthName }}</td>
                                            <td>{{ number_format($monthlyBookings[$i] ?? 0) }}</td>
                                            <td>{{ number_format($monthlyGuests[$i] ?? 0) }}</td>
                                            <td class="fw-bold">₱{{ number_format($monthlyRevenue[$i] ?? 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 日次トレンド (Occupancy) --}}
                <div class="analysis-card">
                    <h6 class="chart-title border-bottom pb-3">
                        <i class="fa-solid fa-chart-line me-2 text-primary"></i>Daily Occupancy Trend ({{ now()->format('F Y') }})
                    </h6>
                    <div class="chart-wrapper mt-3">
                        <canvas id="dailyOccupancyChart"></canvas>
                    </div>
                </div>

                {{-- 月別パフォーマンス (Mixed Chart) --}}
                <div class="analysis-card">
                    <h6 class="chart-title border-bottom pb-3">
                        <i class="fa-solid fa-calendar-check me-2 text-primary"></i>Monthly Booking vs Revenue
                    </h6>
                    <div class="chart-wrapper mt-3">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                {{-- Room Type Section --}}
                <div class="analysis-card">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h6 class="chart-title m-0"><i class="fa-solid fa-door-open me-2 text-primary"></i>Room Type Insights</h6>
                        <ul class="nav nav-pills nav-pills-custom" id="pills-tab">
                            <li class="nav-item">
                                <button class="nav-link active" id="tab-month" data-bs-toggle="pill" data-bs-target="#pills-month">This Month</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-year" data-bs-toggle="pill" data-bs-target="#pills-year">This Year</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-month">
                            <div class="row g-4 text-center">
                                <div class="col-md-6 border-end">
                                    <span class="badge bg-light text-dark mb-3 px-3">Revenue Share</span>
                                    <div class="chart-wrapper"><canvas id="typeChartMonth"></canvas></div>
                                </div>
                                <div class="col-md-6">
                                    <span class="badge bg-light text-dark mb-3 px-3">Booking Volume</span>
                                    <div class="chart-wrapper"><canvas id="typeBookingChartMonth"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-year">
                            <div class="row g-4 text-center">
                                <div class="col-md-6 border-end">
                                    <div class="chart-wrapper"><canvas id="typeChartYear"></canvas></div>
                                </div>
                                <div class="col-md-6">
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
        // 1. グローバルでチャートインスタンスを管理
        let hotelCharts = {};

        document.addEventListener('DOMContentLoaded', function() {
            
            // PHPデータをJS変数に安全に展開
            const monthlyBookings = @json($monthlyBookings ?? []);
            const monthlyRevenue = @json($monthlyRevenue ?? []);
            const monthlyGuests = @json($monthlyGuests ?? []);
            const heatmapData = @json($heatmapData ?? []);

            // --- 共通ドーナツグラフ関数 ---
            const createDoughnut = (id, labels, data) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (hotelCharts[id]) hotelCharts[id].destroy();

                hotelCharts[id] = new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: ['#7da9d8', '#ffcc5c', '#96ceb4', '#ffeead', '#d9a7c7'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%',
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
                    }
                });
            };

            // --- KPI Trends ---
            const kpiCtx = document.getElementById('kpiTrendChart');
            if (kpiCtx) {
                hotelCharts['kpiTrendChart'] = new Chart(kpiCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            { label: 'Bookings', data: monthlyBookings, borderColor: '#7da9d8', tension: 0.3, yAxisID: 'y' },
                            { label: 'Revenue', data: monthlyRevenue, borderColor: '#ff6384', tension: 0.3, yAxisID: 'y1' }
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

            // --- Daily Trend ---
            const dailyCtx = document.getElementById('dailyOccupancyChart');
            if (dailyCtx) {
                hotelCharts['dailyChart'] = new Chart(dailyCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(heatmapData).map(d => d + 'd'),
                        datasets: [{
                            label: 'Active Stays',
                            data: Object.values(heatmapData),
                            borderColor: '#7da9d8',
                            backgroundColor: 'rgba(125, 169, 216, 0.1)',
                            fill: true, tension: 0.4, borderWidth: 2, pointRadius: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { 
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // --- Bar Chart ---
            const barCtx = document.getElementById('barChart');
            if (barCtx) {
                hotelCharts['barChart'] = new Chart(barCtx, {
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            { type: 'line', label: 'Revenue', data: monthlyRevenue, borderColor: '#ff6384', yAxisID: 'y-rev', tension: 0.4 },
                            { type: 'bar', label: 'Bookings', data: monthlyBookings, backgroundColor: '#e2e8f0', yAxisID: 'y-book', borderRadius: 5 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            'y-rev': { position: 'right', display: false },
                            'y-book': { position: 'left', display: false },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // 初期ドーナツ描画
            createDoughnut('typeChartMonth', @json($typeStatsMonth->pluck('label_name') ?? []), @json($typeStatsMonth->pluck('total_sales') ?? []));
            createDoughnut('typeBookingChartMonth', @json($typeBookingStatsMonth->pluck('label_name') ?? []), @json($typeBookingStatsMonth->pluck('booking_count') ?? []));

            // タブイベント
            document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', (e) => {
                    if (e.target.id === 'tab-year') {
                        createDoughnut('typeChartYear', @json($typeStatsYear->pluck('label_name') ?? []), @json($typeStatsYear->pluck('total_sales') ?? []));
                        createDoughnut('typeBookingChartYear', @json($typeBookingStatsYear->pluck('label_name') ?? []), @json($typeBookingStatsYear->pluck('booking_count') ?? []));
                    }
                });
            });

            // 詳細ボタン開閉時のリサイズ
            document.getElementById('detailedAnalysis').addEventListener('shown.bs.collapse', function() {
                if (hotelCharts['kpiTrendChart']) hotelCharts['kpiTrendChart'].resize();
            });
        });
    </script>
@endsection