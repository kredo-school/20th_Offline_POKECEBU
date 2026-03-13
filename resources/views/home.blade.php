@extends('layouts.user')

@section('content')
    <div class="container">
        {{-- 動画ヒーロー --}}
        <div class="hero-wrapper">
            <div class="hero-video">
                <video autoplay muted loop playsinline class="hero-bg-video">
                    <source src="{{ asset('videos/home-beach.mp4') }}" type="video/mp4">
                </video>
                <div class="hero-overlay">
                    <h1 class="hero-title">
                        <span class="mt-5 mb-4 hero-line">Pack Your</span><br>
                        <span class="mb-4 hero-line">Cebu Trip</span><br>
                        <span class="mb-2 hero-line">In A Pocket</span>
                    </h1>
                    <p class="hero-sub">Ready to explore the island?</p>
                </div>
            </div>

            <svg class="wave-line" viewBox="0 0 1000 450" preserveAspectRatio="none">
               
                <path d="M1000,450 C920,285 660,285 500,440 C340,585 100,585 0,445"
                    fill="none" stroke="white" stroke-width="6"opacity="0.8"/>
            </svg>
            <svg width="0" height="0" style="position:absolute">
                <defs>
                    <clipPath id="waveClip" clipPathUnits="objectBoundingBox">
                        <path d="M0,0 H1 V1 C0.88,0.73 0.66,0.73 0.51,1 C0.30,1.35 0.10,1.35 0,1 V0 Z"/>
                    </clipPath>
                </defs>
            </svg>

            <div class="hero-circles">
                <div class="hero-circle circle-1">
                    <div class="circle-content">
                        <span class="circle-label">DATE</span>
                        <div id="current-date">----/--/--</div>
                    </div>
                </div>
                <div class="hero-circle circle-2">
                    <div class="circle-content">
                        <span class="circle-label">TIME</span>
                        <div id="current-time">00:00</div>
                    </div>
                </div>
                <div class="hero-circle circle-3">
                    <div class="circle-content">
                        <span class="circle-label">WEATHER</span>
                        @if (isset($weather['weather'][0]['icon']))
                            <img class="weather-icon"
                                src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png">
                        @endif
                        <div class="temp">{{ round($weather['main']['temp']) }}°C</div>
                    </div>
                </div>
                <div class="hero-circle circle-4">
                    <div class="circle-content">
                        <span class="circle-label">RATE</span>
                        <!-- @if ($rate && $rate > 0)
                            <div class="rate-text">¥1 = ₱{{ number_format($rate, 2) }}</div>
                            <div class="rate-text">₱1 = ¥{{ number_format(1 / $rate, 2) }}</div>
                        @else
                            <div class="rate-text">Loading</div>
                        @endif -->
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="main-card">
                <div class="row g-3 p-3">
                    <div class="col-12 mb-3">
                        <a href="{{ route('user.hotels.index') }}" class="menu-btn menu-hotel text-decoration-none">
                            <i class="fa-solid fa-bed"></i>
                            <div class="menu-text-wrapper">
                                <div class="menu-title">Find Your Stay</div>
                                <div class="menu-subtitle">Experience comfort in Cebu</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 mb-3">
                        <a href="{{ route('user.restaurants.search') }}" class="menu-btn menu-restaurant text-decoration-none">
                            <i class="fa-solid fa-utensils"></i>
                            <div class="menu-text-wrapper">
                                <div class="menu-title">Dine & Savor</div>
                                <div class="menu-subtitle">Taste the local flavors</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 mb-3">
                        <a href="{{ route('user.jeepney.index') }}" class="menu-btn menu-jeepney text-decoration-none">
                            <i class="fa-solid fa-van-shuttle"></i>
                            <div class="menu-text-wrapper">
                                <div class="menu-title">Route & Ride</div>
                                <div class="menu-subtitle">Check numbers and destinations</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 mb-3">
                        <a href="{{ route('user.posts.index') }}" class="menu-btn menu-mypage text-decoration-none">
                            <i class="fa-solid fa-user"></i>
                            <div class="menu-text-wrapper">
                                <div class="menu-title">Share Your Cebu</div>
                                <div class="menu-subtitle">Connect through your stories</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 mb-3">
                        <a href="{{ route('user.daily.fortune.show') }}" class="menu-btn menu-fortune text-decoration-none">
                            <i class="fa-solid fa-star"></i>
                            <div class="menu-text-wrapper">
                                <div class="menu-title">Today's Pick</div>
                                <div class="menu-subtitle">Discover your lucky spot</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- ---------------ホテル ランキング--------------- --}}
                <div class="container pt-5 pb-2">
                    <h3 class="section-title mb-2">
                        <span class="title-decor">Recommended</span>
                        Top Rated Hotels
                        <span class="title-decor">Hotels</span>
                    </h3>

                    {{-- トップ3専用コンテナ --}}
                    <div class="row g-4 justify-content-center top-ranking-wrapper">
                        @php
                            $top3 = $hotelRankings->take(3);
                        @endphp

                        @foreach ($top3 as $index => $hotel)
                            @php 
                                $rank = $index + 1;
                                // 表示アニメーションの遅延時間を設定 (0.1s, 0.2s, 0.3s)
                                $delay = ($index + 1) * 0.1 . 's';
                            @endphp
            
                            <div class="col-12 col-md-4 animate-card" style="animation-delay: {{ $delay }}">
                                <div class="card premium-rank-card h-100 border-0 shadow-lg">
                                    {{-- 画像とオーバーレイエリア --}}
                                    <div class="rank-image-container">
                                        <img src="{{ $hotel->image_path ? Storage::url($hotel->image_path) : asset('images/no-image.png') }}"
                                             alt="{{ $hotel->name }}" class="rank-image">

                                        {{-- ガラスモーフィズム調のオーバーレイ --}}
                                        <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                {{-- 高級感のあるランキングバッジ --}}
                                                <div class="rank-badge-premium rank-{{ $rank }}">
                                                    <span class="rank-num">{{ $rank }}</span>
                                                    <span class="rank-text">RANK</span>
                                                </div>

                                                {{-- お気に入り（既存処理を維持） --}}
                                                <div class="post-like-premium">
                                                    @if ($hotel->isFavorited())
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.destroy', ['hotel', $hotel->id]) }}"
                                                            class="favorite-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn heat-btn">
                                                                <i class="fa-solid fa-heart text-danger"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.store', ['hotel', $hotel->id]) }} "
                                                            class="favorite-form">
                                                            @csrf
                                                            <button type="button" class="btn heat-btn">
                                                                <i class="fa-regular fa-heart"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                            
                                            {{-- 都市名を画像の上に小さく配置 --}}
                                            <p class="card-city-premium mb-0">
                                                <i class="fa-solid fa-location-dot me-1"></i>{{ $hotel->city }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- カード下部の情報エリア --}}
                                    <div class="rank-body p-4">
                                        <a href="{{ route('user.hotels.detail', $hotel->id) }}" class="rank-link-premium">
                                            <h4 class="card-title fw-bold mb-2">{{ $hotel->name }}</h4>
                                        </a>
                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="rank-star">
                                                {{-- 既存の星評価処理 --}}
                                                @php
                                                    $rating = $hotel->star_rating;
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                @endphp
                                                <span class="text-warning small">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $fullStars)
                                                            <i class="fa-solid fa-star"></i>
                                                        @elseif ($i == $fullStars + 1 && $halfStar)
                                                            <i class="fa-solid fa-star-half-stroke"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-muted op-5"></i>
                                                        @endif
                                                    @endfor
                                                    <strong class="text-dark ms-1">{{ number_format($rating, 1) }}</strong>
                                                </span>
                                            </div>
                                        </div>
                        
                                        <div class="card-footer-premium d-flex justify-content-between align-items-center pt-3 border-top">
                                            <span class="text-muted small"></span>
                                            <p class="card-price-premium mb-0">
                                                @if ($hotel->rooms->isNotEmpty())
                                                    <span class="currency">₱</span><span class="price-num">{{ number_format($hotel->rooms->min('charge')) }}</span><span class="tax">〜</span>
                                                @else
                                                    <span class="text-muted small">The price has not been set.</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    {{-- ホバー時の光沢エフェクト用フラグメント --}}
                                    <div class="shine-effect"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ---------------レストラン ランキング--------------- --}}
                <div class="container py-2">
                    <h3 class="section-title mb-2">
                        <span class="title-decor">Recommended</span>
                        Top Rated Restaurants
                        <span class="title-decor">Restaurants</span>
                    </h3>

                    {{-- トップ3専用コンテナ --}}
                    <div class="row g-4 justify-content-center top-ranking-wrapper">
                        @php
                            $top3 = $restaurantRankings->take(3);
                        @endphp

                        @foreach ($top3 as $index => $restaurant)
                            @php 
                                $rank = $index + 1;
                                // 表示アニメーションの遅延時間を設定 (0.1s, 0.2s, 0.3s)
                                $delay = ($index + 1) * 0.1 . 's';
                            @endphp
            
                            <div class="col-12 col-md-4 animate-card" style="animation-delay: {{ $delay }}">
                                <div class="card premium-rank-card h-100 border-0 shadow-lg">
                                    <div class="rank-image-container">
                                        <img src="{{ $restaurant->image_path ? Storage::url($restaurant->image_path) : asset('images/no-image.png') }}"
                                             alt="{{ $restaurant->name }}" class="rank-image">

                                        <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="rank-badge-premium rank-{{ $rank }}">
                                                    <span class="rank-num">{{ $rank }}</span>
                                                    <span class="rank-text">RANK</span>
                                                </div>

                                                <div class="post-like-premium">
                                                    @if ($hotel->isFavorited())
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.destroy', ['restaurant', $restaurant->id]) }}"
                                                            class="favorite-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn heat-btn">
                                                                <i class="fa-solid fa-heart text-danger"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST"
                                                            action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }} "
                                                            class="favorite-form">
                                                            @csrf
                                                            <button type="button" class="btn heat-btn">
                                                                <i class="fa-regular fa-heart"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                            
                                            <p class="card-city-premium mb-0">
                                                <i class="fa-solid fa-location-dot me-1"></i>{{ $restaurant->city }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="rank-body p-4">
                                        <a href="{{ route('user.restaurants.detail', $restaurant->id) }}" class="rank-link-premium">
                                            <h4 class="card-title fw-bold mb-2">{{ $restaurant->name }}</h4>
                                        </a>
                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="rank-star">
                                                @php
                                                    $rating = $restaurant->star_rating;
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                @endphp
                                                <span class="text-warning small">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $fullStars)
                                                            <i class="fa-solid fa-star"></i>
                                                        @elseif ($i == $fullStars + 1 && $halfStar)
                                                            <i class="fa-solid fa-star-half-stroke"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-muted op-5"></i>
                                                        @endif
                                                    @endfor
                                                    <strong class="text-dark ms-1">{{ number_format($rating, 1) }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shine-effect"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- -----------都市別ホテル-------------- --}}
                @foreach ($hotelsByCity as $city => $hotels)
                    <div>
                        <h3 class="section-title">{{ $city }}</h3>
                    </div>

                    <div class="row justify-content-center g-2 mb-3">
                        @foreach ($hotels as $index => $hotel)
                            <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">
                                <div class="card rank-card">
                                    <img src="{{ $hotel->image_path ?? asset('images/no-image.png') }}"
                                        alt="{{ $hotel->name }}" class="rank-image">

                                    <div class="rank-body">
                                        <a href="{{ route('user.hotels.detail', $hotel->id) }}" class="rank-link">
                                            <h5 class="card-title">{{ $hotel->name }}</h5>
                                        </a>
                                        <div class="rank-star">
                                            @php
                                                $rating = $hotel->star_rating;
                                                $fullStars = floor($rating);
                                                $halfStar = $rating - $fullStars >= 0.5;
                                            @endphp
                                            <p class="card-text text-warning">
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
                                                @if ($halfStar)
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                @endif
                                                <span class="text-muted ms-1">{{ number_format($rating, 1) }}</span>
                                            </p>
                                        </div>
                                        <p class="card-city">
                                            <i class="fa-solid fa-location-dot"></i> {{ $hotel->city }}
                                        </p>
                                        <p class="card-price">
                                            @if ($hotel->rooms->isNotEmpty())
                                                ¥{{ $hotel->rooms->min('charge') }}〜
                                            @else
                                                <span class="text-muted">価格未設定</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                {{-- ---------------ポスト--------------- --}}
                <div>
                    <h3 class="recent-posts mb-2">Recent Posts</h3>
                </div>

                <div class="post-slider">
                    <div class="post-track">
                        @foreach ($home_posts as $post)
                            <div class="post-item">
                                <a href="{{ route('user.posts.show', $post->id) }}" class="post-card">
                                    <img src="{{ $post->images->first()->image }}" alt="Post Image">
                                </a>
                            </div>
                        @endforeach

                        {{-- ループ用に同じものをもう一回 --}}
                        @foreach ($home_posts as $post)
                            <div class="post-item">
                                <a href="{{ route('user.posts.show', $post->id) }}" class="post-card">
                                    <img src="{{ $post->images->first()->image }}" alt="Post Image">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.favorite-form').forEach(form => {
                const button = form.querySelector('button');
                if (!button) return;

                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const token = form.querySelector('input[name="_token"]').value;
                    const methodInput = form.querySelector('input[name="_method"]');
                    const isDelete = methodInput && methodInput.value === 'DELETE';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams({
                            _method: isDelete ? 'DELETE' : 'POST'
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            const icon = form.querySelector('i');

                            if (data.status === 'added') {
                                icon.classList.remove('fa-regular');
                                icon.classList.add('fa-solid', 'text-danger');

                                if (!methodInput) {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = '_method';
                                    input.value = 'DELETE';
                                    form.appendChild(input);
                                }

                            } else if (data.status === 'removed') {
                                icon.classList.remove('fa-solid', 'text-danger');
                                icon.classList.add('fa-regular');

                                const m = form.querySelector('input[name="_method"]');
                                if (m) m.remove();
                            }

                        })
                        .catch(error => {
                            console.error(error);
                            alert('通信エラー');
                        });
                });
            });

            // --- 追加：ヒーローセクションの文字出し ---
            const heroLines = document.querySelectorAll('.hero-line');
            heroLines.forEach((line, index) => {
                setTimeout(() => {
                    line.classList.add('appear');
                }, 300 + (index * 200)); // 0.3秒待ってから、0.2秒間隔で順番に出す
            });

            // --- 既存のスクロール監視（Intersection Observer） ---
            const observerOptions = {
                root: null,
                rootMargin: "-20px 0px",
                threshold: 0.3
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.menu-btn').forEach(btn => {
                observer.observe(btn);
            });

            function updateDateTime() {
                const now = new Date();

                // セブ島（フィリピン）の時間
                const options = { timeZone: 'Asia/Manila' };

                // 月/日 (例: 03/09)
                const year = now.toLocaleDateString('en-US', { ...options, year: 'numeric'});
                const month = now.toLocaleDateString('en-US', { ...options, month: '2-digit' });
                const day = now.toLocaleDateString('en-US', { ...options, day: '2-digit' });
                const dateStr = `${year}/${month}/${day}`;
                const dateElement = document.getElementById('current-date');
                if (dateElement) {
                    dateElement.innerHTML = `${dateStr}`;
                }

                // 時刻 (例: 17:35)
                const timeStr = now.toLocaleTimeString('en-US', {
                    ...options, hour: '2-digit', minute: '2-digit', hour12: false
                });
                const timeElement = document.getElementById('current-time');
                if (timeElement) timeElement.textContent = timeStr;
            }

            // 1秒ごとに更新（必要なら）
            setInterval(updateDateTime, 1000);
            updateDateTime();
        });
    </script>

    {{-- CSS --}}
    <style>
        .hero-video {
            position: relative;
            width: 100%;
            height: 450px;
            overflow: visible; /* はみ出し部分を見せるためvisibleに */
            clip-path: url(#waveClip);
        }

        /* 背景動画 */
        .hero-bg-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        /* テキスト */
        .hero-overlay {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* 縦は中央 */
            align-items: flex-start;
            /* 左寄せに変更 */
            color: #fff;
            text-align: left;
            /* テキストも左揃え */
            padding-left: 10%;
            /* 左端から少し離す（おしゃれに見えるポイント） */
        }

        /* 文字を1行ずつ動かすための設定 */
        .hero-line {
            display: inline-block;
            opacity: 0;
            transform: translateY(30px);
            /* 少し下から */
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s ease-out;
        }

        /* アニメーション開始用クラス */
        .hero-line.appear {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-title {
            font-size: 65px;
            font-weight: 900;
            line-height: 1.1;
            text-transform: uppercase;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-title span {
            display: inline-block;
        }

        .hero-sub {
            margin-top: 20px;
            font-size: 20px;
            border-left: 3px solid #fff;
            padding-left: 15px;
        }

        .hero-wrapper {
            position: relative;
            margin-bottom: 150px;
        }

        .wave-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 430px; 
            pointer-events: none;
            z-index: 4;
            overflow: visible; /* 下にはみ出す左側の線を表示 */
        }

        .wave-line path{
            stroke-width:4;
        }

        .hero-circles{
            position:absolute;
            bottom:-120px;
            right:3%;
            display:flex;
            gap:15px;
            z-index:3;
            align-items:flex-end;
        }

        .hero-circle{
            width:120px;
            height:120px;
            border-radius:50%;
            background:white;
            color:#333;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            text-align:center;
        }

        .hero-circle:hover{
            transform:translateY(-8px) scale(1.05);
            box-shadow: 0 20px 45px rgba(0,0,0,.25);
        }

        .circle-1{
            margin-bottom:20px;
            animation:float 6s ease-in-out infinite;
        }

        .circle-2{
            margin-bottom:70px;
            animation:float 7s ease-in-out infinite;
        }

        .circle-3{
            margin-bottom:67px;
            animation:float 5.5s ease-in-out infinite;
        }

        .circle-4{
            margin-bottom:25px;
            animation:float 6.5s ease-in-out infinite;
        }
        
        .circle-label{
            font-size:10px;
            letter-spacing:.15em;
            color:#888;
        }

        .circle-content{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:3px;
        }

        @keyframes float{
            0%{ transform:translateY(0px); }
            50%{ transform:translateY(-6px); }
            100%{ transform:translateY(0px); }
        }

        #current-date, #current-time, .temp, .rate-text{
            font-size:14px;
            font-weight:600;
        }

        .weather-icon{
            width:40px;
        }

        /* メインメニュー */
        .menu-btn {
            width: 100%;
            height: 180px;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);

            /* アニメーション共通設定 */
            opacity: 0;
            transition: transform 1.0s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.0s ease-out;
            pointer-events: none;

            /* 背景画像用（個別クラスに書いても良いが、共通化しておくと楽） */
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        /* 表示された時（共通） */
        .menu-btn.show {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto;
        }

        /* ホバー時の浮き上がり（共通） */
        .menu-btn.show:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* --- 個別背景オーバーレイ（共通化） --- */
        .menu-btn::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .menu-btn i,
        .menu-btn div {
            position: relative;
            z-index: 2;
        }

        .menu-text-wrapper {
            position: relative;
            z-index: 2;
            text-align: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .menu-title {
            font-size: 26px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 2px;
        }

        .menu-subtitle {
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 0.05em;
            opacity: 0.9;
        }

        /* --- 共通：アイコンの基本設定 --- */
        .menu-btn i {
            font-size: 42px;
            margin-bottom: 15px;
            opacity: 0.9;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .menu-hotel:hover i,
        .menu-jeepney:hover i, .menu-fortune:hover i  {
            transform: scale(1.15) rotate(10deg);
        }

        .menu-restaurant:hover i,
        .menu-mypage:hover i {
            transform: scale(1.15) rotate(-10deg);
        }

        .menu-hotel i,
        .menu-jeepney i, .menu-fortune i {
            transform: rotate(-5deg);
        }

        .menu-restaurant i,
        .menu-mypage i {
            transform: rotate(5deg);
        }

        .menu-hotel,
        .menu-jeepney, .menu-fortune {
            border-radius: 0 150px 150px 0;
            transform: translateX(-100px);
            margin-left: -1rem;
            width: calc(100% + 1rem);
        }

        .menu-restaurant,
        .menu-mypage {
            border-radius: 150px 0 0 150px;
            transform: translateX(100px);
            margin-right: -1rem;
            width: calc(100% + 1rem);
        }

        .menu-hotel {
            background-image: url("{{ asset('images/home-hotel.jpg') }}");
            background-position: center 75%;
        }

        .menu-restaurant {
            background-image: url("{{ asset('images/home-restaurant.jpg') }}");
            background-position: center 70%;
        }

        .menu-jeepney {
            background-image: url("{{ asset('images/home-jeepney.jpg') }}");
            background-position: center 80%;
        }

        .menu-mypage {
            background-image: url("{{ asset('images/home-post.jpg') }}");
            background-position: center 12%;
        }

        .menu-fortune {
            background-image: url("{{ asset('images/home-fortune.jpg') }}");
            background-position: center 60%;
        }

        .section-title, .recent-posts {
            position: relative;
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: #333;
            padding: 40px 0;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        /* 背後の薄い文字 */
        .section-title::before, .recent-posts::before {
            content: "TOP 3 SELECTION";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4.5rem;
            color: rgba(79, 163, 209, 0.08); /* 非常に薄い青 */
            z-index: -1;
            white-space: nowrap;
            font-family: 'Arial Black', sans-serif;
        }

        /* 下の装飾ライン */
        .section-title::after, .recent-posts::after {
            content: "";
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 8px;
            /* 波線を背景画像(SVG)で表現 */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 4'%3E%3Cpath d='M0 3.5c5 0 5-3 10-3s5 3 10 3' fill='none' stroke='%234fa3d1' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: repeat-x;
            background-size: 20px auto;
            animation: wave-move 3s linear infinite;
            opacity: 0.8;
        }

        .section-title::before {
            content: "TOP 3 SELECTION";
        }     
        .recent-posts::before {
            content: "SHARE YOUR CEBU";   
        }

        @keyframes wave-move {
            0% {
                background-position: 0 bottom;
            }
            100% {
                background-position: 20px bottom;
            }
        }

        .title-decor {
            display: block;
            font-size: 12px;
            color: #4fa3d1;
            font-weight: 400;
            letter-spacing: 3px;
        }

        /* --- カード全体の動きとデザイン --- */
        .premium-rank-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            transform-style: preserve-3d; /* 3D効果のため */
        }

        /* ホバー時の挙動：浮き上がりと影の強調 */
        .premium-rank-card:hover {
            transform: translateY(-15px) rotateX(3deg) rotateY(1deg);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        /* ロード時のアニメーション用Keyframes */
        @keyframes fadeInUpCard {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            opacity: 0;
            animation: fadeInUpCard 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }

        /* --- 画像エリアの動き --- */
        .rank-image-container {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 11;
            overflow: hidden;
        }

        .rank-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1); /* ゆっくり動かす */
        }

        /* ホバー時の挙動：画像拡大＆スライド */
        .premium-rank-card:hover .rank-image {
            transform: scale(1.1) translateX(10px);
        }

        /* --- 画像の上のオーバーレイ要素 --- */
        /* ガラスモーフィズム調の背景グラデーション */
        .card-img-overlay {
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 40%, rgba(0,0,0,0.6) 100%);
            border-radius: 20px 20px 0 0;
        }

        /* 高級感のあるランキングバッジ */
        .rank-badge-premium {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 0 0 15px 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #333;
            font-family: 'Georgia', serif; /* 英字でおしゃれに */
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .rank-badge-premium .rank-num {
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
        }

        .rank-badge-premium .rank-text {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* 順位ごとのテーマカラー（バッジの文字色やボーダーに） */
        .rank-1 .rank-num { color: #d4af37; /* Gold */ }
        .rank-2 .rank-num { color: #8a8a8a; /* Silver */ }
        .rank-3 .rank-num { color: #b08d57; /* Bronze */ }

        /* 都市名の表示 */
        .card-city-premium {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        /* お気に入りボタンの調整 */
        .post-like-premium .heat-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }

        .post-like-premium .heat-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #e74c3c;
            transform: scale(1.1);
        }

        /* --- 情報エリア --- */
        .rank-link-premium {
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
        }

        .rank-link-premium:hover {
            color: #4fa3d1;
        }

        .premium-rank-card .card-title {
            font-size: 19px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* 価格の表示 */
        .card-price-premium {
            color: #333;
            font-weight: 800;
        }

        .card-price-premium .currency {
            font-size: 16px;
            vertical-align: super;
        }

        .card-price-premium .price-num {
            font-size: 26px;
            letter-spacing: -1px;
        }

        .card-price-premium .tax {
            font-size: 14px;
            color: #777;
            font-weight: 400;
        }

        /* --- ホバー時の光沢エフェクト --- */
        .shine-effect {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            z-index: 10;
        }

        .premium-rank-card:hover .shine-effect {
            animation: shine 0.75s;
        }

        @keyframes shine {
            100% {
                left: 125%;
            }
        }

        /* POST */
        .post-card {
            position: relative;
            display: block;
            overflow: hidden;
            aspect-ratio: 3 / 4.2;
            width: 100%;
            max-width: 280px;
            color: #ffffff;
            text-decoration: none;
            border: 6px solid white;
        }

        /* 画像 */
        .post-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
            filter: brightness(0.9);
        }

        /* スライダー */
        .post-slider {
            overflow: hidden;
            width: 100%;
            padding-bottom: 60px;
            -webkit-mask-image: linear-gradient(
                to right,
                transparent,
                black 12%,
                black 88%,
                transparent
            );
            mask-image: linear-gradient(
                to right,
                transparent,
                black 12%,
                black 88%,
                transparent
            );
        }

        .post-track {
            display: flex;
            gap: 15px;
            width: max-content;
            animation: scrollPosts 60s linear infinite;
        }

        .post-item {
            flex: 0 0 auto;
            width: 280px;
            padding-top: 20px;
        }

        /* 写真をランダム回転 */
        .post-item:nth-child(odd) .post-card {
            transform: rotate(-4deg);
        }
        .post-item:nth-child(even) .post-card {
            transform: rotate(3deg);
        }
        .post-item:nth-child(3n) .post-card {
            transform: rotate(-6deg);
        }
        .post-item:nth-child(4n) .post-card {
            transform: rotate(5deg);
        }

        .post-item:nth-child(6n+1){margin-top:20px;}
        .post-item:nth-child(6n+2){margin-top:0;}
        .post-item:nth-child(6n+3){margin-top:35px;}
        .post-item:nth-child(6n+4){margin-top:10px;}
        .post-item:nth-child(6n+5){margin-top:40px;}
        .post-item:nth-child(6n+6){margin-top:15px;}

        /* 左に流れる */
        @keyframes scrollPosts {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
    </style>
@endsection