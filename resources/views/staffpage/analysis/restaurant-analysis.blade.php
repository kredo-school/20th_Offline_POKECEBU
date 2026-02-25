@extends('layouts.staff')
 
@section('title', 'Analysis of Restaurant')
 
@section('content')

    <style>
        .analysis-container { background: white; padding: 25px; margin-bottom: 25px; border-radius: 15px; }
        .kpi-box { border-radius: 15px; padding: 25px; text-align: center; flex: 1; min-width: 200px; background: #ffffff; border: 1px solid #f0f0f0; }
        .chart-title { font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; }
        .chart-wrapper { position: relative; height: 300px !important; width: 100%; }
        .btn-detail { border-radius: 20px; padding: 8px 25px; font-weight: bold; }
    </style>

    <div class="container py-4">
        {{-- 今月のKPIカード --}}
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

        {{-- 詳細エリア (デフォルトは非表示) --}}
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
                                            <td>{{ number_format($monthlyBookings[$i]) }}</td>
                                            <td>{{ number_format($monthlyGuests[$i]) }}</td>
                                            <td>{{ number_format($monthlyAvgStay[$i], 1) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 既存のグラフセクション --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="analysis-container shadow-sm">
                    <h6 class="chart-title border-bottom pb-3"><i class="fa-solid fa-clock me-2 text-warning"></i>Peak Hours Analysis</h6>
                    <div class="chart-wrapper" style="height: 300px;"><canvas id="hourlyPeakChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="analysis-container shadow-sm h-100">
                    <h6 class="chart-title border-bottom pb-3"><i class="fa-solid fa-chart-line me-2 text-warning"></i>Daily Booking Volume</h6>
                    <div class="chart-wrapper"><canvas id="dailyBookingChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let charts = {};

            // 1. KPI Trends Chart (詳細エリア内)
            charts['kpiTrendChart'] = new Chart(document.getElementById('kpiTrendChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        { label: 'Bookings', data: @json($monthlyBookings), borderColor: '#f39c12', tension: 0.3, yAxisID: 'y' },
                        { label: 'Guests', data: @json($monthlyGuests), borderColor: '#e67e22', tension: 0.3, yAxisID: 'y' },
                        { label: 'Avg. Stay', data: @json($monthlyAvgStay), borderColor: '#2ecc71', borderDash: [5,5], tension: 0.3, yAxisID: 'y1' }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, position: 'left' }, y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } } }
                }
            });

            // 2. Daily Chart
            new Chart(document.getElementById('dailyBookingChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(@json($dailyData)).map(d => d + 'd'),
                    datasets: [{ label: 'Reservations', data: Object.values(@json($dailyData)), borderColor: '#f39c12', fill: true, backgroundColor: 'rgba(243, 156, 18, 0.1)', tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
            
            // 4. Hourly Peak Chart
            new Chart(document.getElementById('hourlyPeakChart'), {
                type: 'line',
                data: {
                    labels: Array.from({ length: 24 }, (_, i) => i + ':00'),
                    datasets: [{ label: 'Reservations', data: @json($hourlyStats), borderColor: '#f39c12', backgroundColor: 'rgba(243, 156, 18, 0.1)', fill: true, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            // Collapse表示時にグラフをリサイズ
            document.getElementById('detailedAnalysis').addEventListener('shown.bs.collapse', function () {
                charts['kpiTrendChart'].resize();
            });
        });
    </script>
@endsection