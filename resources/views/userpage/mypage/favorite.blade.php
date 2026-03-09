@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/mypage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/favorite.css') }}">
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
            <a href="{{ route('booking') }}" class="ig-nav-item">
                <i class="fa-regular fa-calendar"></i> Bookings
            </a>
            <a href="{{ route('favorite') }}" class="ig-nav-item active">
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

        {{-- ── フィルターボタン ── --}}
        <div class="fav-filter-bar">
            <button class="fav-filter-btn active" data-type="all">
                <i class="fa-regular fa-heart"></i> All
            </button>
            <button class="fav-filter-btn" data-type="hotel">
                <i class="fa-regular fa-building"></i> Hotel
            </button>
            <button class="fav-filter-btn" data-type="restaurant">
                <i class="fa-regular fa-utensils"></i> Restaurant
            </button>
        </div>

        {{-- ── カードグリッド ── --}}
        <div class="fav-grid">

            @if ($favoriteHotels->isEmpty() && $favoriteRestaurants->isEmpty())
                <div class="fav-empty">
                    <i class="fa-regular fa-heart"></i>
                    <p>No Favorites yet</p>
                </div>
            @else

                {{-- Hotels --}}
                @foreach ($favoriteHotels as $hotel)
                    <a href="{{ route('user.hotels.detail', $hotel->id) }}"
                       class="fav-card fav-item" data-type="hotel">
                        @if ($hotel->image_path)
                            <img src="{{ $hotel->image_path }}" alt="{{ $hotel->name }}" class="fav-card-img">
                        @else
                            <div class="fav-card-img-placeholder">
                                <i class="fa-regular fa-image"></i>
                            </div>
                        @endif
                        <div class="fav-card-body">
                            <div class="fav-card-type">Hotel</div>
                            <div class="fav-card-name">{{ $hotel->name }}</div>
                            <div class="fav-card-city">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $hotel->city }}
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- Restaurants --}}
                @foreach ($favoriteRestaurants as $restaurant)
                    <a href="{{ route('user.restaurants.detail', $restaurant->id) }}"
                       class="fav-card fav-item" data-type="restaurant">
                        @if ($restaurant->image_path)
                            <img src="{{ $restaurant->image_path }}" alt="{{ $restaurant->name }}" class="fav-card-img">
                        @else
                            <div class="fav-card-img-placeholder">
                                <i class="fa-regular fa-image"></i>
                            </div>
                        @endif
                        <div class="fav-card-body">
                            <div class="fav-card-type">Restaurant</div>
                            <div class="fav-card-name">{{ $restaurant->name }}</div>
                            <div class="fav-card-city">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $restaurant->city }}
                            </div>
                        </div>
                    </a>
                @endforeach

                {{-- フィルター後の空状態 --}}
                <div class="fav-empty" id="fav-empty-msg" style="display:none;">
                    <i class="fa-regular fa-heart"></i>
                    <p>No Favorites yet</p>
                </div>

            @endif

        </div>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btns  = document.querySelectorAll('.fav-filter-btn');
    const items = document.querySelectorAll('.fav-item');
    const emptyMsg = document.getElementById('fav-empty-msg');

    btns.forEach(btn => {
        btn.addEventListener('click', function () {
            btns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const type = this.dataset.type;
            let visible = 0;

            items.forEach(item => {
                const show = type === 'all' || item.dataset.type === type;
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (emptyMsg) emptyMsg.style.display = visible === 0 ? 'block' : 'none';
        });
    });
});
</script>
@endsection