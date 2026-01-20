@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/staff.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm"
     style="background-color:#6FA9DE; height:80px;">
    @include('layouts.partials.nav-staff')
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center title-main mb-2">Reservation Analysis</h1>
    <h2 class="text-center title-month mb-5">May</h2>

    <div class="row justify-content-center g-4">
        <!-- Number of Customers -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">100</div>
                <div class="stat-label">Number of Customers</div>
            </div>
        </div>

        <!-- Sales -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">100,000</div>
                <div class="stat-label">Sales</div>
            </div>
        </div>
    </div>

    <!-- 月ごとのグラフ -->
    <div class="mt-5">
        <canvas id="monthlyChart" width="600" height="300"></canvas>
    </div>
</div>

<!-- Chart.js読み込み -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');

const monthlyChart = new Chart(ctx, {
    type: 'bar', // 棒グラフ
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'], // 月ラベル
        datasets: [
            {
                label: 'Number of Customers',
                data: [80, 95, 120, 90, 100, 110], // サンプルデータ
                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            },
            {
                label: 'Sales',
                data: [80000, 95000, 120000, 90000, 100000, 110000], // サンプルデータ
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // CanvasサイズをCSSで調整可能
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<style>
/* タイトルとカードのスタイル */
.title-main {
    font-weight: 700;
    font-size: 2.2rem;
    color: #343a40;
}
.title-month {
    font-weight: 600;
    font-size: 1.6rem;
    color: #495057;
}
.stat-card {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0d6efd;
}
.stat-label {
    font-size: 0.95rem;
    color: #6c757d;
}
#monthlyChart {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>
@endsection
