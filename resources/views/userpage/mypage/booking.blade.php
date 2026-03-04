@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/mypage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/booking.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="mypage-wrapper">

    {{-- ── 左サイドバー（mypageと同一構造） ── --}}
    <aside class="ig-sidebar">
        <div class="ig-sidebar-profile">
            <div class="ig-sidebar-avatar">
                <div class="ig-sidebar-avatar-inner">
                    @if ($user->detail?->avatar)
                        <img src="{{ $user->detail->avatar }}" alt="avatar">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                </div>
            </div>
            <div class="ig-sidebar-name">
                {{ $user->detail?->first_name ?? '' }} {{ $user->detail?->last_name ?? 'ユーザー' }}
            </div>
            <div class="ig-sidebar-email">{{ $user->email }}</div>
        </div>

        <nav class="ig-sidebar-nav">
            <a href="{{ route('mypage') }}" class="ig-nav-item">
                <i class="fa-regular fa-user"></i> Profile
            </a>
            <a href="{{ route('user.mypage.post') }}" class="ig-nav-item">
                <i class="fa-regular fa-images"></i> Posts
            </a>
            <a href="{{ route('booking') }}" class="ig-nav-item active">
                <i class="fa-regular fa-calendar"></i> Bookings
            </a>
            <a href="{{ route('favorite') }}" class="ig-nav-item">
                <i class="fa-regular fa-heart"></i> Favorite
            </a>
        </nav>
    </aside>

    {{-- ── 右コンテンツ ── --}}
    <main class="ig-content">

        {{-- プロフィールヘッダー（mypageと同一構造） --}}
        <div class="ig-profile-card">
            <div class="ig-avatar-ring">
                <div class="ig-avatar-inner">
                    @if ($user->detail?->avatar)
                        <img src="{{ $user->detail->avatar }}" alt="avatar">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                </div>
            </div>
            <div class="ig-profile-info">
                <div class="ig-username">
                    <span>{{ $user->detail?->first_name ?? '' }} {{ $user->detail?->last_name ?? 'ユーザー' }}</span>
                </div>
                <div class="ig-email">{{ $user->email }}</div>
            </div>
        </div>

        {{-- ── タブ ── --}}
        <div class="bk-tabs">
            <button class="bk-tab-btn active" onclick="switchTab('hotel', this)">
                <i class="fa-regular fa-building"></i> Hotel
            </button>
            <button class="bk-tab-btn" onclick="switchTab('restaurant', this)">
                <i class="fa-regular fa-utensils"></i> Restaurant
            </button>
        </div>

        {{-- ════════════════════════
             HOTEL タブ
        ════════════════════════ --}}
        <div class="bk-tab-pane active" id="tab-hotel">

            {{-- Upcoming --}}
            <div class="bk-section-title"><i class="fa-regular fa-clock me-1"></i> Upcoming</div>
            @forelse($upcomingHotels as $res)
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon"><i class="fa-regular fa-building"></i></div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->hotel->name ?? 'N/A' }}</div>
                            <div class="bk-card-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($res->start_at)->format('M d, Y') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i> {{ \Carbon\Carbon::parse($res->end_at)->format('M d, Y') }}</span>
                                <span><i class="fa-regular fa-user"></i> {{ $res->guests }} guests</span>
                            </div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge active"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Active</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No upcoming hotel reservations.</div>
            @endforelse

            {{-- Past --}}
            <div class="bk-section-title"><i class="fa-regular fa-clock-rotate-left me-1"></i> Past</div>
            @forelse($pastHotels as $res)
                @php $review = $res->hotel->reviewBy(auth()->id()); @endphp
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon" style="background:#f5f5f5;color:#9e9e9e;">
                            <i class="fa-regular fa-building"></i>
                        </div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->hotel->name ?? 'N/A' }}</div>
                            <div class="bk-card-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($res->start_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge completed"><i class="fa-solid fa-check" style="font-size:9px;"></i> Completed</span>
                            <button class="bk-review-btn {{ $review ? 'done' : '' }}"
                                {{ $review ? '' : "data-bs-toggle=modal data-bs-target=#reviewModal{$res->hotel->id}" }}>
                                <i class="fa-{{ $review ? 'solid' : 'regular' }} fa-star"></i>
                                {{ $review ? '投稿済み' : 'Write Review' }}
                            </button>
                        </div>
                    </div>
                </div>
                @include('userpage.mypage.modals.review', ['target' => $res->hotel, 'type' => 'hotel'])
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No past hotel reservations.</div>
            @endforelse

            {{-- Cancelled --}}
            <div class="bk-section-title"><i class="fa-regular fa-ban me-1"></i> Cancelled</div>
            @forelse($cancelledHotels as $res)
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon" style="background:#fdecea;color:#c62828;">
                            <i class="fa-regular fa-building"></i>
                        </div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->hotel->name ?? 'N/A' }}</div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge cancelled"><i class="fa-solid fa-xmark" style="font-size:9px;"></i> Cancelled</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No cancelled hotel reservations.</div>
            @endforelse

        </div>{{-- /tab-hotel --}}


        {{-- ════════════════════════
             RESTAURANT タブ
        ════════════════════════ --}}
        <div class="bk-tab-pane" id="tab-restaurant">

            {{-- Upcoming --}}
            <div class="bk-section-title"><i class="fa-regular fa-clock me-1"></i> Upcoming</div>
            @forelse($upcomingRestaurants as $res)
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon" style="background:#fff8e1;color:#f9a825;">
                            <i class="fa-regular fa-utensils"></i>
                        </div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->restaurant->name ?? 'N/A' }}</div>
                            <div class="bk-card-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($res->start_at)->format('M d, Y H:i') }}</span>
                                <span><i class="fa-regular fa-user"></i> {{ $res->guests }} guests</span>
                            </div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge active"><i class="fa-solid fa-circle" style="font-size:6px;"></i> Active</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No upcoming restaurant reservations.</div>
            @endforelse

            {{-- Past --}}
            <div class="bk-section-title"><i class="fa-regular fa-clock-rotate-left me-1"></i> Past</div>
            @forelse($pastRestaurants as $res)
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon" style="background:#f5f5f5;color:#9e9e9e;">
                            <i class="fa-regular fa-utensils"></i>
                        </div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->restaurant->name ?? 'N/A' }}</div>
                            <div class="bk-card-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($res->start_at)->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge completed"><i class="fa-solid fa-check" style="font-size:9px;"></i> Completed</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No past restaurant reservations.</div>
            @endforelse

            {{-- Cancelled --}}
            <div class="bk-section-title"><i class="fa-regular fa-ban me-1"></i> Cancelled</div>
            @forelse($cancelledRestaurants as $res)
                <div class="bk-card">
                    <div class="bk-card-body">
                        <div class="bk-card-icon" style="background:#fdecea;color:#c62828;">
                            <i class="fa-regular fa-utensils"></i>
                        </div>
                        <div class="bk-card-info">
                            <div class="bk-card-name">{{ $res->restaurant->name ?? 'N/A' }}</div>
                            <div class="bk-res-id mt-1"># {{ $res->reservation_id }}</div>
                        </div>
                        <div class="bk-card-right">
                            <div class="bk-price">₱{{ number_format($res->total_price, 2) }}</div>
                            <span class="bk-badge cancelled"><i class="fa-solid fa-xmark" style="font-size:9px;"></i> Cancelled</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bk-empty"><i class="fa-regular fa-calendar-xmark"></i>No cancelled restaurant reservations.</div>
            @endforelse

        </div>{{-- /tab-restaurant --}}

    </main>
</div>

<script>
function switchTab(name, btn) {
    // タブボタン
    document.querySelectorAll('.bk-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    // タブパネル
    document.querySelectorAll('.bk-tab-pane').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
}
</script>
@endsection