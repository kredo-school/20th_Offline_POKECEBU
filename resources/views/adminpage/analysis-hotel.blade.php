@extends('layouts.admin')
 
@section('title', 'Admin Analysis of Hotel')
 
@section('content')

    <style>
        .btn-sidebar {
            border: 1px solid #333; border-radius: 0;
            background-color: white; color: black; width: 100%; margin-bottom: -1px;
        }
        .btn-sidebar.active { background-color: #7da9d8; font-weight: bold; }
        .analysis-container { border: 1px solid #333; background: white; padding: 30px; margin-bottom: 20px; }
        .kpi-box { background-color: #e2e2e2; border-radius: 12px; padding: 20px; text-align: center; width: 280px; }
    </style>
<div class="container">
    <h1 class="mb-5">Analysis Hotel</h1>

    <div class="row">
        <div class="col-md-2">
            <div class="d-flex flex-column" id="menuGroup">
                <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar active">Hotel</a>
                <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar">Restaurant</a>
            </div>
        </div>

        <div class="col-md-10">
            <div class="analysis-container">
                <h4 class="text-center mb-4">May</h4>
                <div class="d-flex justify-content-center gap-4">
                    <div class="kpi-box">
                        <div class="small">Number of customers</div>
                        <div class="display-6" id="kpi-customers">100</div>
                    </div>
                    <div class="kpi-box">
                        <div class="small">Sales</div>
                        <div class="display-6" id="kpi-sales">100,000</div>
                    </div>
                </div>
            </div>

            <div class="analysis-container">
                <div class="row">
                    <div class="col-md-6"><canvas id="barChart"></canvas></div>
                    <div class="col-md-6"><canvas id="lineChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // データ定義
    const dataSet = {
        restaurant: {
            title: "Restaurant",
            customers: "100",
            sales: "100,000",
            barData: [28000, 32000, 35000, 30000, 29000, 31000, 27000, 28000, 29000, 38000, 42000, 30000],
            lineData1: [7, 7, 8, 7, 8, 8, 7, 6, 8, 7, 7, 8],
            lineData2: [8, 6, 8, 6, 9, 8, 5, 7, 6, 6, 6, 7]
        },
        hotel: {
            title: "Hotel",
            customers: "450",
            sales: "2,500,000",
            barData: [45000, 48000, 52000, 41000, 43000, 55000, 60000, 62000, 50000, 48000, 44000, 58000],
            lineData1: [9, 8, 9, 8, 9, 10, 10, 10, 9, 8, 8, 9],
            lineData2: [5, 4, 6, 5, 7, 6, 8, 9, 7, 5, 4, 6]
        }
    };

    let barChart, lineChart;

    // グラフ初期化
    function initCharts() {
        const ctxBar = document.getElementById('barChart');
        barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                datasets: [{ label: '件数', data: dataSet.restaurant.barData, backgroundColor: '#5b84b1' }]
            }
        });

        const ctxLine = document.getElementById('lineChart');
        lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                datasets: [
                    { label: '稼働率', data: dataSet.restaurant.lineData1, borderColor: '#5b84b1' },
                    { label: '満足度', data: dataSet.restaurant.lineData2, borderColor: '#b05b5b' }
                ]
            }
        });
    }

    // 表示更新関数
    function updateDashboard(type) {
        // タイトルとKPIの更新
        document.getElementById('currentPageTitle').innerText = dataSet[type].title;
        document.getElementById('kpi-customers').innerText = dataSet[type].customers;
        document.getElementById('kpi-sales').innerText = dataSet[type].sales;

        // ボタンの活性状態切り替え
        const buttons = document.querySelectorAll('.btn-sidebar');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        // グラフデータの更新
        barChart.data.datasets[0].data = dataSet[type].barData;
        barChart.update();

        lineChart.data.datasets[0].data = dataSet[type].lineData1;
        lineChart.data.datasets[1].data = dataSet[type].lineData2;
        lineChart.update();
    }

    window.onload = initCharts;
</script>
@endsection
 