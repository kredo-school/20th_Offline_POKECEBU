@extends('layouts.admin')

@section('title', 'Admin Analysis of Restaurant')

@section('content')

    <style>
        .btn-sidebar {
            border: 1px solid #333;
            border-radius: 0;
            background-color: white;
            color: black;
            width: 100%;
            margin-bottom: -1px;
        }
        .btn-sidebar.active {
            background-color: #7da9d8;
            font-weight: bold;
        }
        .analysis-container {
            border: 1px solid #333;
            background: white;
            padding: 30px;
            margin-bottom: 20px;
        }
        .kpi-box {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            width: 280px;
        }
        .ls-1 { letter-spacing: 1px; }
    </style>

    <div class="container py-4">
        <h1 class="mb-5 fw-bold">Analysis Restaurant</h1>

        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-2">
                <div class="d-flex flex-column" id="menuGroup">
                    <a href="{{ route('admin.analysis.hotel') }}" class="btn btn-sidebar">Hotel</a>
                    <a href="{{ route('admin.analysis.restaurant') }}" class="btn btn-sidebar active">Restaurant</a>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-md-10">
                
                {{-- KPI Section --}}
                <div class="analysis-container shadow-sm border-0 rounded-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fa-solid fa-utensils me-2"></i>Summary of {{ now()->format('F') }}
                    </h4>
                    <div class="d-flex justify-content-center gap-4 flex-wrap">

                        <div class="kpi-box border-0 shadow-sm" style="background: #f8f9fa;">
                            <div class="text-muted small fw-bold text-uppercase ls-1">Total Diners</div>
                            <div class="display-5 fw-bold text-primary">{{ number_format($kpi->customers) }}</div>
                            <div class="text-success small mt-2">
                                <i class="fa-solid fa-caret-up"></i> 8% vs last month
                            </div>
                        </div>

                        <div class="kpi-box border-0 shadow-sm" style="background: #f8f9fa;">
                            <div class="text-muted small fw-bold text-uppercase ls-1">Total Sales</div>
                            <div class="display-5 fw-bold text-dark">${{ number_format($kpi->sales) }}</div>
                            <div class="text-muted small mt-2">
                                Avg. ${{ $kpi->customers > 0 ? number_format($kpi->sales / $kpi->customers) : 0 }} / table
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Chart Section --}}
                <div class="analysis-container shadow-sm border-0 rounded-4">
                    <div class="row">
                        <div class="col-md-8 mx-auto"> {{-- レストラン用は1つのグラフを大きく表示 --}}
                            <h6 class="text-center fw-bold mb-3">Monthly Restaurant Bookings</h6>
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxBar = document.getElementById('barChart');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Bookings',
                        data: @json($monthlyBookings),
                        backgroundColor: 'rgba(91, 132, 177, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: { 
                    responsive: true,
                    plugins: { 
                        legend: { display: false } 
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endsection