@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-hotel.css') }}">
@endpush

@section('content')
    <div class="ig-main-container">
        <div class="ig-card">
            {{-- Header --}}
            <div class="ig-card-header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="ig-card-title">Hotel Profile</h2>
                    <p class="ig-card-subtitle">Public information of your hotel</p>
                </div>
                <a href="{{ route('hotel.staff.mypage.hotel.edit') }}" class="ig-btn-primary">
                    Edit / Apply Changes
                </a>
            </div>

            {{-- $hotel が null の場合、以下すべてをスキップ --}}
            @if ($hotel)

                {{-- Hotel Visual Section --}}
                <div class="ig-profile-header mb-5">
                    @if ($hotel->images->isNotEmpty())
                        @foreach ($hotel->images as $image)
                            <img src="{{ $image->image }}"  class="ig-hotel-img" alt="Hotel Image">
                        @endforeach
                    @else
                        <img src="https://via.placeholder.com/150" class="ig-hotel-img" alt="No Image">
                    @endif
                </div>

                {{-- Information Grid --}}
                <div class="ig-info-grid">
                    <div class="ig-info-item">
                        <span class="ig-info-label">Representative</span>
                        <span class="ig-info-value">{{ $hotel->representative_name ?? 'Not set' }}</span>
                    </div>
                    <div class="ig-info-item">
                        <span class="ig-info-label">Email</span>
                        <span class="ig-info-value">{{ $hotel->representative_email ?? 'Not set' }}</span>
                    </div>
                    <div class="ig-info-item">
                        <span class="ig-info-label">Phone</span>
                        <span class="ig-info-value">{{ $hotel->phone ?? 'Not set' }}</span>
                    </div>
                    <div class="ig-info-item">
                        <span class="ig-info-label">Website</span>
                        <span class="ig-info-value">
                            @if ($hotel->website)
                                <a href="{{ $hotel->website }}" target="_blank" class="ig-link">{{ $hotel->website }}</a>
                            @else
                                Not set
                            @endif
                        </span>
                    </div>
                    <div class="ig-info-item full-width">
                        <span class="ig-info-label">Address</span>
                        <span class="ig-info-value">{{ $hotel->address ?? 'Not set' }}, {{ $hotel->city ?? '' }}</span>
                    </div>
                </div>

            @else
                <p class="text-muted text-center py-4">No hotel information.</p>
            @endif

        </div>

        <div class="ig-history-card">
            <h4 class="ig-summary-title mb-4" style="font-size: 18px; font-weight: 700;">Application History</h4>
            <div class="table-responsive">
                <table class="table history-table align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Hotel Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history ?? [] as $item)
                            <tr>
                                <td class="text-muted" style="font-size: 13px;">
                                    {{ $item->created_at->format('Y/m/d H:i') }}</td>
                                <td class="fw-bold" style="font-size: 14px;">{{ $item->name }}</td>
                                <td>
                                    @if ($item->status == 'pending')
                                        <span class="status-badge status-pending">Pending Review</span>
                                    @elseif($item->status == 'approved')
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
