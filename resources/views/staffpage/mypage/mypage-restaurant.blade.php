@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-hotel.css') }}">
    <style>
        .ig-history-card {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #DBDBDB;
            border-radius: 12px;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending  { background-color: #FFF4E5; color: #B7791F; }
        .status-approved { background-color: #F0FFF4; color: #276749; }
        .status-rejected { background-color: #FFF5F5; color: #C53030; }
        .history-table th {
            font-size: 11px;
            text-transform: uppercase;
            color: #8E8E8E;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #EFEFEF;
        }
    </style>
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card">
        <div class="ig-card-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="ig-card-title">Restaurant Profile</h2>
                <p class="ig-card-subtitle">Current public information</p>
            </div>
            <a href="{{ route('restaurant.staff.edit.restaurant') }}" class="ig-btn-primary">
                Edit / Apply Changes
            </a>
        </div>

        @if ($restaurant)
            {{-- ビジュアルセクション --}}
            {{-- restaurant_images テーブルのbase64画像を表示 --}}
            <div class="ig-profile-header mb-5">
                <div class="ig-avatar-container">
                    @if ($restaurant->images->isNotEmpty())
                        @foreach ($restaurant->images as $image)
                            <img src="{{ $image->image }}" alt="Restaurant Image" class="ig-hotel-img">
                        @endforeach
                    @else
                        <img src="https://via.placeholder.com/150" alt="No Image" class="ig-hotel-img">
                    @endif
                </div>
                <div class="ig-hotel-info">
                    <h3 class="ig-hotel-name">{{ $restaurant->name ?? 'Not Registered' }}</h3>
                    <div class="ig-rating">
                        <span class="badge bg-light text-dark border">{{ $restaurant->city ?? 'Location unset' }}</span>
                    </div>
                    <p class="ig-hotel-desc">{{ $restaurant->description ?? 'No description provided.' }}</p>
                </div>
            </div>

            {{-- 基本情報グリッド --}}
            <div class="ig-info-grid">
                <div class="ig-info-item">
                    <span class="ig-info-label">Representative</span>
                    <span class="ig-info-value">{{ $restaurant->representative_name ?? '-' }}</span>
                </div>
                <div class="ig-info-item">
                    <span class="ig-info-label">Email</span>
                    <span class="ig-info-value">{{ $restaurant->email ?? '-' }}</span>
                </div>
                <div class="ig-info-item">
                    <span class="ig-info-label">Phone</span>
                    <span class="ig-info-value">{{ $restaurant->phone ?? '-' }}</span>
                </div>
                <div class="ig-info-item">
                    <span class="ig-info-label">Website</span>
                    <span class="ig-info-value">
                        @if ($restaurant->website)
                            <a href="{{ $restaurant->website }}" target="_blank" class="ig-link">Visit Website</a>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="ig-info-item full-width">
                    <span class="ig-info-label">Address</span>
                    <span class="ig-info-value">{{ $restaurant->address ?? '-' }}</span>
                </div>
            </div>

        @else
            <p class="text-muted text-center py-4">Restaurant information has not been registered yet.</p>
        @endif
    </div>

    {{-- 申請履歴 --}}
    <div class="ig-history-card">
        <h4 class="ig-summary-title mb-4" style="font-size: 18px; font-weight: 700;">Application History</h4>
        <div class="table-responsive">
            <table class="table history-table align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Restaurant Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history ?? [] as $item)
                        <tr>
                            <td class="text-muted" style="font-size: 13px;">{{ $item->created_at->format('Y/m/d H:i') }}</td>
                            <td class="fw-bold" style="font-size: 14px;">{{ $item->name }}</td>
                            <td>
                                @if ($item->status == 'pending')
                                    <span class="status-badge status-pending">Pending Review</span>
                                @elseif ($item->status == 'approved')
                                    <span class="status-badge status-approved">Approved</span>
                                @else
                                    <span class="status-badge status-rejected">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="fa-solid fa-clock-rotate-left mb-2" style="font-size: 24px;"></i><br>
                                No recent applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection