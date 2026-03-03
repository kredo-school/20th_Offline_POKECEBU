@extends('layouts.admin')

@section('title', 'Admin Analysis of Users')

@section('content')

    <div class="analysis-wrapper">
        <div class="row g-5">
            {{-- 1. Sidebar (左側) --}}
            <div class="col-lg-2">
                <div class="d-flex flex-column mb-4">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar mb-2 text-start shadow-sm">
                        <i class="fa-solid fa-hotel me-2"></i>Hotel
                    </a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar mb-2 text-start shadow-sm">
                        <i class="fa-solid fa-utensils me-2"></i>Restaurant
                    </a>
                    <hr class="my-3 text-muted">
                    <a href="#" class="btn btn-sidebar active text-start shadow-sm">
                        <i class="fa-solid fa-users-gear me-2"></i>User Insights
                    </a>
                </div>
            </div>

            {{-- 2. Main Content (右側) --}}
            <div class="col-lg-10">
                
                {{-- KPI Section --}}
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="kpi-box shadow-sm border-0 bg-white p-4 rounded-4">
                            <p class="text-muted small fw-bold mb-2 text-uppercase ls-1">Total Registered Users</p>
                            <h3 class="fw-black m-0 text-dark display-6">{{ number_format($totalUsers) }}</h3>
                            <span class="badge bg-light text-secondary mt-2 border">Cumulative Total</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kpi-box shadow-sm border-0 bg-white p-4 rounded-4 border-start border-primary border-4">
                            <p class="text-muted small fw-bold mb-2 text-primary text-uppercase ls-1">New Signups This Month</p>
                            <h3 class="fw-black text-primary m-0 display-6">{{ number_format($newThisMonth) }}</h3>
                            <span class="badge bg-primary bg-opacity-10 text-primary mt-2">Current Month Growth</span>
                        </div>
                    </div>
                </div>

                {{-- 詳細表示ボタン --}}
                <div class="text-center mb-5">
                    <button class="btn btn-outline-dark rounded-pill px-5 shadow-sm fw-bold border-2" type="button" data-bs-toggle="collapse" data-bs-target="#detailedUserReport">
                        <i class="fa-solid fa-chart-area me-2"></i>Show Annual Growth Report
                    </button>
                </div>

                {{-- 折りたたみ：月次レポート --}}
                <div class="collapse mb-5" id="detailedUserReport">
                    <div class="analysis-card border-0 shadow-sm bg-white p-4 rounded-4 mb-4">
                        <h6 class="chart-title border-bottom pb-3 fw-bold mb-4">User Acquisition History (Last 12 Months)</h6>
                        <div class="chart-wrapper" style="height: 350px;">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>

                    <div class="analysis-card p-0 overflow-hidden shadow-sm border-0 bg-white rounded-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start ps-4 py-3">Month</th>
                                        <th class="py-3">New Registrations</th>
                                        <th class="text-end pe-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monthlyUserStats as $data)
                                        <tr>
                                            <td class="text-start ps-4 fw-bold text-dark">{{ $data->month_name }}</td>
                                            <td class="fw-bold">{{ number_format($data->signups) }}</td>
                                            <td class="text-end pe-4">
                                                @if($data->signups > 0)
                                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3">Active</span>
                                                @else
                                                    <span class="text-muted small italic">No signups</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- デバイス分布などのサブ分析（必要に応じて追加） --}}
                <div class="analysis-card border-0 shadow-sm bg-white p-4 rounded-4">
                    <h6 class="chart-title border-bottom pb-3 fw-bold mb-4">
                        <i class="fa-solid fa-chart-line me-2 text-primary"></i>Daily Growth Visualization
                    </h6>
                    <p class="text-muted small mb-4">The graph below visualizes the distribution of user signups across the selected period.</p>
                    <div class="chart-wrapper" style="height: 300px;">
                        <canvas id="userBarChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // 1. PHPからデータを取得し、確実に「数値」に変換する
    const monthLabels = @json($monthLabels);
    const rawGrowthData = @json($growthData);
    // 文字列を数値に変換 (例: ["1"] -> [1])
    const growthData = Object.values(rawGrowthData).map(Number);

    let userGrowthChart;
    let userBarChart;

    // グラフ描画関数
    const initCharts = () => {
        // --- A. User Growth Chart (Line) ---
        const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const gradient = growthCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        userGrowthChart = new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'New Registrations',
                    data: growthData, // 数値配列
                    borderColor: '#3b82f6',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...growthData) + 2, // 最大値より少し上に余裕を持たせる
                        ticks: { stepSize: 1, precision: 0 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- B. User Bar Chart ---
        const barCtx = document.getElementById('userBarChart').getContext('2d');
        userBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Signups',
                    data: growthData,
                    backgroundColor: '#3b82f6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    };

    // 初期化実行
    initCharts();

    // 【解決策】詳細レポート（Collapse）が開いた時に再計算させる
    const collapseElement = document.getElementById('detailedUserReport');
    if (collapseElement) {
        collapseElement.addEventListener('shown.bs.collapse', function () {
            window.dispatchEvent(new Event('resize')); // ブラウザ全体にリサイズを通知
            if (userGrowthChart) {
                userGrowthChart.resize();
                userGrowthChart.update();
            }
        });
    }
});
    </style>
@endsection