@extends('layouts.admin')
 
@section('title', 'Admin Analysis of Restaurants')
 
@section('content')
    
    <style>
        
        /* サイドバーボタンのカスタム */
        .btn-sidebar {
            border: 1px solid #333;
            border-radius: 0;
            background-color: white;
            color: black;
            width: 100%;
            margin-bottom: -1px; /* 枠線の重なり調整 */
        }
        .btn-sidebar.active {
            background-color: #7da9d8; /* 画像の青色 */
        }

        /* 外枠のボックス */
        .analysis-container {
            border: 1px solid #333;
            background: white;
            padding: 30px;
            margin-bottom: 20px;
        }

        /* グレーのKPIカード */
        .kpi-box {
            background-color: #e2e2e2;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            width: 280px;
        }
    </style>

<div class="container">
    <h1 class="mb-5">Analysis Restaurant</h1>

    <div class="row">
        <div class="col-md-2">
            <div class="d-flex flex-column">
                <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar">Hotel</a>
                <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar active">Restaurant</a>
            </div>
        </div>

        <div class="col-md-10">
            
            <div class="analysis-container">
                <h4 class="text-center mb-4">May</h4>
                <div class="d-flex justify-content-center gap-4">
                    <div class="kpi-box">
                        <div class="small">Number of customers</div>
                        <div class="display-6">100</div>
                    </div>
                    <div class="kpi-box">
                        <div class="small">Sales</div>
                        <div class="display-6">100,000</div>
                    </div>
                </div>
            </div>

            <div class="analysis-container">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 棒グラフの設定
    const ctxBar = document.getElementById('barChart');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            datasets: [{
                label: '件数',
                data: [28000, 32000, 35000, 30000, 29000, 31000, 27000, 28000, 29000, 38000, 42000, 30000],
                backgroundColor: '#5b84b1'
            }]
        }
    });

    // 折れ線グラフの設定
    const ctxLine = document.getElementById('lineChart');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            datasets: [
                {
                    label: 'データ1',
                    data: [7, 7, 8, 7, 8, 8, 7, 6, 8, 7, 7, 8],
                    borderColor: '#5b84b1',
                    tension: 0.1
                },
                {
                    label: 'データ2',
                    data: [8, 6, 8, 6, 9, 8, 5, 7, 6, 6, 6, 7],
                    borderColor: '#b05b5b',
                    tension: 0.1
                }
            ]
        }
    });
</script>
@endsection
 