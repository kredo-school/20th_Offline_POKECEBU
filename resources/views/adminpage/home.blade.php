@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    <style>
        /* 1. 全体のカラーパレットと余白 */
        :root {
            --admin-bg: #f4f7f6; /* ほんのりグレーの背景 */
            --card-white: #ffffff;
            --text-main: #1e293b; /* 濃いインディゴグレー */
            --text-muted: #64748b;
            --brand-primary: #3b82f6; /* ブルー */
            --brand-accent: #e76f51; /* テラコッタオレンジ */
            --brand-warning: #f39c12; /* ゴールド */
            --brand-danger: #ef4444; /* レッド */
            --brand-success: #22c55e; /* グリーン */
        }

        body {
            background-color: var(--admin-bg);
            color: var(--text-main);
            font-family: 'Inter', 'Noto Sans JP', sans-serif; /* モダンなフォント */
        }

        .main-content-wrapper {
            padding: 50px 20px;
        }

        /* 2. ヘッダー周り */
        .dashboard-header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 45px;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 850;
            letter-spacing: -1.5px;
            color: var(--text-main);
            margin-bottom: 0;
        }

        /* 3. KPIカード（白ベースで影を工夫） */
        .kpi-card {
            background: var(--card-white);
            border: none;
            border-radius: 24px; /* 丸みを強く */
            box-shadow: 0 10px 40px rgba(29, 52, 54, 0.08); /* 柔らかい影 */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(29, 52, 54, 0.12);
        }

        .kpi-card .card-body {
            padding: 35px;
        }

        .kpi-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .bg-icon-all-users { background-color: rgba(59, 130, 246, 0.1); color: var(--brand-primary); }
        .bg-icon-new-reg { background-color: rgba(231, 111, 81, 0.1); color: var(--brand-accent); }

        .kpi-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .kpi-value {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 8px;
            letter-spacing: -2.5px;
            color: var(--text-main);
        }

        .kpi-meta {
            font-size: 0.85rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        /* 4. 承認待ちセクション */
        .pending-section {
            background: var(--card-white);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(29, 52, 54, 0.05);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--brand-warning);
            margin-right: 15px;
        }

        /* 承認リストアイテム */
        .pending-item {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 18px;
            transition: all 0.25s ease;
            border: 1px solid #e2e8f0;
        }

        .pending-item:hover {
            background: #fafcfc;
            border-color: #cbd5e1;
            transform: translateX(5px);
        }

        .item-icon {
            width: 55px;
            height: 55px;
            background: #f1f5f9;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--text-main);
            margin-right: 25px;
        }

        .item-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .item-status {
            font-size: 0.95rem;
            font-weight: 700;
        }

        /* 承認待ちがある場合のパルスアニメーション */
        .status-pulse {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: var(--brand-danger);
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 0 rgba(239, 68, 68, 0.4);
            animation: pulse 2.5s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .text-pending { color: var(--brand-danger); }
        .text-clear { color: var(--brand-success); }

        .view-list-btn {
            background-color: transparent;
            color: var(--brand-warning);
            font-weight: 800;
            font-size: 0.85rem;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 30px;
            border: 2px solid rgba(243, 156, 18, 0.2);
            transition: all 0.2s;
        }

        .view-list-btn:hover {
            background-color: var(--brand-warning);
            color: #ffffff;
            border-color: var(--brand-warning);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.2);
        }
    </style>

    <div class="main-content-wrapper">
        {{-- Header --}}
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <h1 class="page-title">Admin Dashboard</h1>
            <div class="text-end text-muted">
                <div class="fw-bold fs-5" style="color: var(--text-main);">{{ now()->format('Y / M / d') }}</div>
                <div class="small">{{ now()->format('l, H:i') }}</div>
            </div>
        </div>

        {{-- 1. KPI Cards Row (col-md-6) --}}
        <div class="row g-4 mb-5 justify-content-center">
            {{-- All Users --}}
            <div class="col-md-6 col-xl-5">
                <div class="card kpi-card">
                    <div class="card-body">
                        <div class="kpi-icon-wrapper bg-icon-all-users">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="kpi-label">Total Registered Users</div>
                        <a href="{{ route('admin.showAllUsers') }}" class="text-decoration-none">
                            <div class="kpi-value">{{ number_format($totalUsers) }}</div>
                        </a>
                        <div class="kpi-meta">
                            <i class="fa-solid fa-database me-2 text-success"></i>
                            System-wide total database records
                        </div>
                    </div>
                </div>
            </div>

            {{-- New Registrations --}}
            <div class="col-md-6 col-xl-5">
                <div class="card kpi-card">
                    <div class="card-body">
                        <div class="kpi-icon-wrapper bg-icon-new-reg">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div class="kpi-label">New Users / {{ now()->format('F') }}</div>
                        <div class="kpi-value" style="color: var(--brand-accent);">{{ number_format($newRegistrationCount) }}</div>
                        <div class="kpi-meta">
                            <i class="fa-solid fa-chart-line me-2 text-info"></i>
                            Accounts joined this month
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Pending Approvals Section --}}
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="pending-section border border-light shadow-sm">
                    <h5 class="section-title border-bottom pb-3">
                        <i class="fa-solid fa-bell"></i>Pending Approvals
                    </h5>

                    {{-- Hotels --}}
                    <div class="pending-item d-flex align-items-center justify-content-between shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="item-icon">
                                <i class="fa-solid fa-hotel"></i>
                            </div>
                            <div class="item-name">Hotels</div>
                        </div>
                        
                        <div class="item-status text-center">
                            @if ($countTmpHotel > 0)
                                <div class="text-pending d-flex align-items-center fw-bold">
                                    <span class="status-pulse"></span>
                                    {{ $countTmpHotel }} requests waiting
                                </div>
                            @else
                                <div class="text-clear fw-bold">
                                    <i class="fa-solid fa-check-circle me-1"></i>All clear
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.showList', 'hotel') }}" class="view-list-btn">
                                Review List <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Restaurants --}}
                    <div class="pending-item d-flex align-items-center justify-content-between shadow-sm border-0 mb-0">
                        <div class="d-flex align-items-center">
                            <div class="item-icon">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div class="item-name">Restaurants</div>
                        </div>
                        
                        <div class="item-status text-center">
                            @if ($countTmpRestaurant > 0)
                                <div class="text-pending d-flex align-items-center fw-bold">
                                    <span class="status-pulse"></span>
                                    {{ $countTmpRestaurant }} requests waiting
                                </div>
                            @else
                                <div class="text-clear fw-bold">
                                    <i class="fa-solid fa-check-circle me-1"></i>All clear
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.showList', 'restaurant') }}" class="view-list-btn">
                                Review List <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection