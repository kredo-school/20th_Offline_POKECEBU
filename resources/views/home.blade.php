@extends('layouts.user')

@section('content')
    <div class="top-video pb-4" style="background-color: #e3f5f9;">
        <div class="hero-wrapper">
            <div class="hero-video">
                <video autoplay muted loop playsinline class="hero-bg-video">
                    <source src="{{ asset('videos/home-beach.mp4') }}" type="video/mp4">
                </video>
                <div class="hero-overlay">
                    <h1 class="hero-title">
                        <span class="mt-5 mb-3 hero-line">Pack Your</span><br>
                        <span class="mb-3 hero-line">Cebu Trip</span><br>
                        <span class="mb-2 hero-line">In Your Pocket</span>
                    </h1>
                    <p class="hero-sub">Ready to explore the island?</p>
                </div>
            </div>

            <svg class="wave-line" viewBox="0 0 1000 450" preserveAspectRatio="none">
                <path d="M1000,450 C920,285 660,285 500,440 C340,585 100,585 0,445"
                    fill="none" stroke="white" stroke-width="6" opacity="0.8"/>
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
                        <!-- @if (isset($weather['weather'][0]['icon']))
                            <img class="weather-icon"
                                src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png">
                        @endif
                        <div class="temp">{{ round($weather['main']['temp']) }}°C</div> -->
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
    </div>

    <div class="pt-4" style="background-color: #f8fafc;">
        <div class="row justify-content-center">
            <div class="main-card col-10">
                <div class="p-3">
                    <div class="menu-wrapper">
                        <div class="menu-heading">What will you do?</div>

                        <div class="row menu-section pb-5">
                            <div class="col-lg-6 menu-left border">
                                <div class="ms-3 mt-3 mb-3">
                                    <h2 class="menu-title">Find Your Perfect Stay</h2>
                                    <h5 class="menu-subtitle">Discover comfortable hotels in Cebu</h5>
                                    <p class="menu-text">
                                        From beachfront resorts to cozy city hotels, explore a wide range of
                                        places to stay in Cebu. Whether you're traveling for relaxation,
                                        adventure, or business, find the perfect accommodation that suits
                                        your style and budget.
                                    </p>
                                    <a href="{{ route('user.hotels.index') }}" class="menu-text-btn text-decoration-none">
                                        Find Hotels
                                        <i class="fa-solid fa-bed"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 menu-right">
                                <a href="{{ route('user.hotels.index') }}" class="menu-btn menu-hotel text-decoration-none">
                                    <svg class="menu-edge-line" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="65,-10 85,50 65,110" fill="none" stroke="#f8fafc" stroke-width="30" vector-effect="non-scaling-stroke"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="row menu-section pb-5">
                            <div class="col-lg-6 menu-right">
                                <a href="{{ route('user.restaurants.search') }}" class="menu-btn menu-restaurant text-decoration-none">
                                    <svg class="menu-edge-line" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="35,-10 15,50 35,110" fill="none" stroke="#f8fafc" stroke-width="30" vector-effect="non-scaling-stroke"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="col-lg-6 menu-left ps-4 border">
                                <div class="me-3 mt-3 mb-3">
                                    <h2 class="menu-title">Discover Cebu's Dining</h2>
                                    <h5 class="menu-subtitle">From local favorites to seaside dining</h5>
                                    <p class="menu-text">
                                        Explore Cebu's vibrant food scene, from beloved local eateries to stylish
                                        restaurants by the sea. Whether you're craving authentic Filipino dishes,
                                        fresh seafood, or international cuisine, find the perfect place to enjoy a
                                        memorable meal.
                                    </p>
                                    <div class="text-end">
                                        <a href="{{ route('user.restaurants.search') }}" class="menu-text-btn text-decoration-none">
                                            <i class="fa-solid fa-utensils"></i>
                                            Find Restaurants
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row menu-section pb-5">
                            <div class="col-lg-6 menu-left border">
                                <div class="ms-3 mt-3 mb-3">
                                    <h2 class="menu-title">Route & Ride</h2>
                                    <h5 class="menu-subtitle">Explore Cebu like a local</h5>
                                    <p class="menu-text">
                                        Jeepneys are one of the most popular ways locals get around Cebu.
                                        They run across the city all day, connect many destinations, and cost
                                        only a few pesos to ride. Learn the routes, hop on like a local, and
                                        explore Cebu in a fun and affordable way.
                                    </p>
                                    <a href="{{ route('user.jeepney.index') }}" class="menu-text-btn text-decoration-none">
                                        Jeepney
                                        <i class="fa-solid fa-van-shuttle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 menu-right">
                                <a href="{{ route('user.jeepney.index') }}" class="menu-btn menu-jeepney text-decoration-none">
                                    <svg class="menu-edge-line" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="65,-10 85,50 65,110" fill="none" stroke="#f8fafc" stroke-width="30" vector-effect="non-scaling-stroke"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="row menu-section pb-5">
                            <div class="col-lg-6 menu-right">
                                <a href="{{ route('user.posts.index') }}" class="menu-btn menu-mypage text-decoration-none">
                                    <svg class="menu-edge-line" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="35,-10 15,50 35,110" fill="none" stroke="#f8fafc" stroke-width="30" vector-effect="non-scaling-stroke"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="col-lg-6 menu-left ps-4 border">
                                <div class="me-3 mt-3 mb-3">
                                    <h2 class="menu-title">Share Your Cebu Moments</h2>
                                    <h5 class="menu-subtitle">Discover experiences from fellow travelers</h5>
                                    <p class="menu-text">
                                        Explore real moments shared by visitors and locals across Cebu.
                                        From hidden beaches to must-try restaurants and unforgettable adventures,
                                        get inspired by authentic experiences and share your own journey with the community.
                                    </p>
                                    <div class="text-end">
                                        <a href="{{ route('user.posts.index') }}" class="menu-text-btn text-decoration-none">
                                            <i class="fa-solid fa-user"></i>
                                            Posts
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row menu-section">
                            <div class="col-lg-6 menu-left border">
                                <div class="ms-3 mt-3 mb-3">
                                    <h2 class="menu-title">Today's Pick</h2>
                                    <h5 class="menu-subtitle">Discover your lucky spot</h5>
                                    <p class="menu-text">
                                        Cebu is full of amazing places to explore, from hidden cafes to beautiful
                                        beaches and lively local spots. If you're not sure where to go next, try
                                        your luck and let today's pick decide your destination. You might discover
                                        a new favorite place you never expected.
                                    </p>
                                    <a href="{{ route('user.daily.fortune.show') }}" class="menu-text-btn text-decoration-none">
                                        Fortune
                                        <i class="fa-solid fa-star"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 menu-right">
                                <a href="{{ route('user.daily.fortune.show') }}" class="menu-btn menu-fortune text-decoration-none">
                                    <svg class="menu-edge-line" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                        <polyline points="65,-10 85,50 65,110" fill="none" stroke="#f8fafc" stroke-width="30" vector-effect="non-scaling-stroke"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-3" style="background-color: #d5e6f9; position: relative;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; z-index: 1;">
            <svg viewBox="0 0 1000 120" preserveAspectRatio="none"
                style="display: block; width: 100%; height: 120px;">
                <path d="M1000,0 C920,115 660,115 500,60 C340,5 100,5 0,60 L0,0 Z"
                    fill="#f8fafc"/>
            </svg>
        </div>
        <div style="position: relative; z-index: 2;">
            <div class="row justify-content-center pt-5">
                <div class="main-card col-10 pt-5">
                    <div class="ranking-heading">Top-Rated</div>
                    <p class="ranking-subtext">
                        Discover the top 3 highest-rated hotels and restaurants.<br>
                        Not sure where to go? You might find<br>your next spot right here!
                    </p>

                    {{-- ホテル ランキング --}}
                    <div class="container">
                        <div class="ranking-circle-wrapper hotel-ranking">
                            <div class="ranking-bg-circle"></div>
                            <div class="ranking-title-overlay ranking-title-right">
                                Hotels
                            </div>

                            @php $top3 = $hotelRankings->take(3); @endphp

                            @foreach ($top3 as $index => $hotel)
                                @php
                                    $rank = $index + 1;
                                    $delay = ($rank * 0.1) . 's';
                                @endphp
                                <div class="ranking-card-pos rank-pos-{{ $rank }} animate-card" style="animation-delay: {{ $delay }}">
                                    <div class="card premium-rank-card border-0 shadow-lg">
                                        <div class="rank-image-container">
                                            <a href="{{ route('user.hotels.detail', ['id' => $hotel->id]) }}">
                                                <img src="{{ $hotel->image_path }}" alt="{{ $hotel->name }}" class="rank-image">
                                            </a>
                                            <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="rank-badge-premium rank-{{ $rank }}">
                                                        <span class="rank-num">{{ $rank }}</span>
                                                        <span class="rank-text">RANK</span>
                                                    </div>
                                                    <div class="post-like-premium">
                                                        @if ($hotel->isFavorited())
                                                            <form method="POST" action="{{ route('user.favorite.destroy', ['hotel', $hotel->id]) }}" class="favorite-form">
                                                                @csrf @method('DELETE')
                                                                <button type="button" class="btn heat-btn"><i class="fa-solid fa-heart text-danger"></i></button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('user.favorite.store', ['hotel', $hotel->id]) }}" class="favorite-form">
                                                                @csrf
                                                                <button type="button" class="btn heat-btn"><i class="fa-regular fa-heart"></i></button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="card-city-premium mb-0"><i class="fa-solid fa-location-dot me-1"></i>{{ $hotel->city }}</p>
                                            </div>
                                        </div>
                                        <div class="rank-body p-3">
                                            <a href="{{ route('user.hotels.detail', $hotel->id) }}" class="rank-link-premium">
                                                <h4 class="card-title fw-bold mb-2">{{ $hotel->name }}</h4>
                                            </a>
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
                                                        <i class="fa-regular fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <strong class="text-dark ms-1">{{ number_format($rating, 1) }}</strong>
                                            </span>
                                        </div>
                                        <div class="shine-effect"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- レストラン ランキング --}}
                    <div class="container py-2">
                        <div class="ranking-circle-wrapper restaurant-ranking">
                            <div class="ranking-bg-circle"></div>
                            <div class="ranking-title-overlay ranking-title-left">
                                Restaurants
                            </div>

                            @php $top3 = $restaurantRankings->take(3); @endphp

                            @foreach ($top3 as $index => $restaurant)
                                @php
                                    $rank = $index + 1;
                                    $delay = ($rank * 0.1) . 's';
                                @endphp
                                <div class="ranking-card-pos rank-pos-{{ $rank }} animate-card" style="animation-delay: {{ $delay }}">
                                    <div class="card premium-rank-card border-0 shadow-lg">
                                        <div class="rank-image-container">
                                            <img src="{{ $restaurant->image_path }}" alt="{{ $restaurant->name }}" class="rank-image">
                                            <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="rank-badge-premium rank-{{ $rank }}">
                                                        <span class="rank-num">{{ $rank }}</span>
                                                        <span class="rank-text">RANK</span>
                                                    </div>
                                                    <div class="post-like-premium">
                                                        @if ($restaurant->isFavorited())
                                                            <form method="POST" action="{{ route('user.favorite.destroy', ['restaurant', $restaurant->id]) }}" class="favorite-form">
                                                                @csrf @method('DELETE')
                                                                <button type="button" class="btn heat-btn"><i class="fa-solid fa-heart text-danger"></i></button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }}" class="favorite-form">
                                                                @csrf
                                                                <button type="button" class="btn heat-btn"><i class="fa-regular fa-heart"></i></button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="card-city-premium mb-0"><i class="fa-solid fa-location-dot me-1"></i>{{ $restaurant->city }}</p>
                                            </div>
                                        </div>
                                        <div class="rank-body p-3">
                                            <a href="{{ route('user.restaurants.detail', $restaurant->id) }}" class="rank-link-premium">
                                                <h4 class="card-title fw-bold mb-2">{{ $restaurant->name }}</h4>
                                            </a>
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
                                                        <i class="fa-regular fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <strong class="text-dark ms-1">{{ number_format($rating, 1) }}</strong>
                                            </span>
                                        </div>
                                        <div class="shine-effect"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ポスト --}}
    <div class="pt-5" style="background-color: #f8fafc; position: relative;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; z-index: 1;">
            <svg viewBox="0 0 1000 120" preserveAspectRatio="none"
                style="display: block; width: 100%; height: 120px;">
                <path d="M1000,0 C920,115 660,115 500,60 C340,5 100,5 0,60 L0,0 Z"
                    fill="#d5e6f9"/>
            </svg>
        </div>
        <div class="pt-5">
            <div class="recent-heading">Recent Posts</div>
            <p class="recent-subtext">
                Discover real moments shared by travelers and locals.<br>
                Get inspired and find your next Cebu experience!
            </p>
        </div>

        <div class="post-slider pb-5">
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

            const heroLines = document.querySelectorAll('.hero-line');
            heroLines.forEach((line, index) => {
                setTimeout(() => {
                    line.classList.add('appear');
                }, 300 + (index * 200));
            });

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
                const options = { timeZone: 'Asia/Manila' };

                const year  = now.toLocaleDateString('en-US', { ...options, year: 'numeric' });
                const month = now.toLocaleDateString('en-US', { ...options, month: '2-digit' });
                const day   = now.toLocaleDateString('en-US', { ...options, day: '2-digit' });
                const dateStr = `${year}/${month}/${day}`;

                const dateElement = document.getElementById('current-date');
                if (dateElement) dateElement.innerHTML = dateStr;

                const timeStr = now.toLocaleTimeString('en-US', {
                    ...options, hour: '2-digit', minute: '2-digit', hour12: false
                });
                const timeElement = document.getElementById('current-time');
                if (timeElement) timeElement.textContent = timeStr;
            }

            setInterval(updateDateTime, 1000);
            updateDateTime();
        });
    </script>

    <style>
        /* ===== レイアウト ===== */
        .main-card {
            position: relative;
            z-index: 1;
        }

        .menu-wrapper {
            position: relative;
            z-index: 0;
            padding: 20px 10px 30px 10px;
        }

        .menu-heading {
            position: absolute;
            top: -65px;
            left: -90px;
            font-size: 100px;
            font-weight: 700;
            line-height: 0.9;
            color: rgba(0, 0, 0, 0.2);
            z-index: -1;
        }

        /* ===== ヒーローセクション ===== */
        .top-video {
            background: linear-gradient(180deg,
                #9eebf7 0%,
                #cff4fa 50%,
                #f8fafc 100%);
        }

        .hero-video {
            position: relative;
            width: 100%;
            height: 450px;
            overflow: visible;
            clip-path: url(#waveClip);
        }

        .hero-bg-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .hero-overlay {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            color: #fff;
            text-align: left;
            padding-left: 5%;
        }

        .hero-line {
            display: inline-block;
            opacity: 0;
            transform: translateY(30px);
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.2s ease-out;
        }

        .hero-line.appear {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-title {
            font-size: 65px;
            font-weight: 600;
            letter-spacing: 2px;
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
            padding-bottom: 200px;
        }

        .wave-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 430px;
            pointer-events: none;
            z-index: 4;
            overflow: visible;
        }

        .wave-line path {
            stroke-width: 4;
        }

        /* ===== ヒーロー円 ===== */
        .hero-circles {
            position: absolute;
            bottom: 80px;
            right: 3%;
            display: flex;
            gap: 15px;
            z-index: 3;
            align-items: flex-end;
        }

        .hero-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .hero-circle:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        }

        .circle-1 { margin-bottom: 20px; animation: float 6s ease-in-out infinite; }
        .circle-2 { margin-bottom: 70px; animation: float 7s ease-in-out infinite; }
        .circle-3 { margin-bottom: 67px; animation: float 5.5s ease-in-out infinite; }
        .circle-4 { margin-bottom: 25px; animation: float 6.5s ease-in-out infinite; }

        .circle-label {
            font-size: 10px;
            letter-spacing: 0.15em;
            color: #888;
        }

        .circle-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
        }

        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-6px); }
            100% { transform: translateY(0px); }
        }

        #current-date,
        #current-time,
        .temp,
        .rate-text {
            font-size: 14px;
            font-weight: 600;
        }

        .weather-icon {
            width: 40px;
        }

        /* ===== メインメニュー ===== */
        .menu-btn {
            width: 100%;
            height: 100%;
            min-height: 330px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transition: transform 1.0s cubic-bezier(0.16, 1, 0.3, 1), opacity 1.0s ease-out;
            pointer-events: none;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .menu-btn.show {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto;
        }

        .menu-btn.show:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .menu-btn::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .menu-btn i,
        .menu-btn div {
            position: relative;
            z-index: 2;
        }

        .menu-section {
            min-height: 330px;
            align-items: stretch;
        }

        .menu-section > [class*="col"] {
            display: flex;
            flex-direction: column;
        }

        .menu-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
        }

        .menu-right {
            padding: 0;
        }

        .menu-title {
            font-size: 35px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 15px;
        }

        .menu-subtitle {
            font-size: 20px;
            color: #666;
            margin-bottom: 20px;
        }

        .menu-text {
            font-size: 14px;
            line-height: 1.8;
            color: #555;
            max-width: 520px;
            margin-bottom: 25px;
        }

        .menu-text-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            background: #0d6efd;
            color: white;
            border-radius: 40px;
            font-weight: 600;
            transition: 0.3s;
            width: fit-content;
            align-self: flex-start;
        }

        .menu-text-btn:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        .menu-edge-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            pointer-events: none;
        }

        .menu-btn i {
            font-size: 42px;
            margin-bottom: 15px;
            opacity: 0.9;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .menu-hotel:hover i,
        .menu-jeepney:hover i,
        .menu-fortune:hover i {
            transform: scale(1.15) rotate(10deg);
        }

        .menu-restaurant:hover i,
        .menu-mypage:hover i {
            transform: scale(1.15) rotate(-10deg);
        }

        .menu-hotel i,
        .menu-jeepney i,
        .menu-fortune i {
            transform: rotate(-5deg);
        }

        .menu-restaurant i,
        .menu-mypage i {
            transform: rotate(5deg);
        }

        .menu-hotel,
        .menu-jeepney,
        .menu-fortune {
            clip-path: polygon(0 0, 80% 0, 100% 50%, 80% 100%, 0 100%);
            transform: translateX(-100px);
            width: 100%;
            height: 100%;
            min-height: 330px;
            will-change: transform;
        }

        .menu-restaurant,
        .menu-mypage {
            clip-path: polygon(20% 0, 100% 0, 100% 100%, 20% 100%, 0 50%);
            transform: translateX(100px);
            width: 100%;
            height: 100%;
            min-height: 330px;
            will-change: transform;
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
            background-image: url("{{ asset('images/home-jeepney.png') }}");
            background-position: right 30%;
        }

        .menu-mypage {
            background-image: url("{{ asset('images/home-post.jpg') }}");
            background-position: center 12%;
        }

        .menu-fortune {
            background-image: url("{{ asset('images/home-fortune.jpg') }}");
            background-position: center 60%;
        }

        /* ===== ランキング ===== */
        .ranking-heading {
            position: relative;
            top: 30px;
            text-align: right;
            font-size: 100px;
            font-weight: 700;
            line-height: 0.9;
            color: rgba(102, 102, 102, 0.7);
            z-index: 0;
            pointer-events: none;
        }

        .ranking-subtext {
            text-align: right;
            max-width: 600px;
            margin-left: auto;
            margin-top: 50px;
            font-size: 20px;
            line-height: 1.8;
            color: rgb(102, 102, 102);
            letter-spacing: 0.5px;
            margin-bottom: -150px;
        }

        .ranking-circle-wrapper {
            position: relative;
            width: 100%;
            height: 600px;
        }

        .ranking-bg-circle {
            position: absolute;
            width: 530px;
            height: 530px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 40px rgba(100, 160, 210, 0.15);
            z-index: 0;
        }

        .ranking-card-pos {
            position: absolute;
            width: 300px;
            z-index: 2;
        }

        /* ホテルランキング */
        .hotel-ranking .ranking-bg-circle {
            top: 100px;
            left: 0px;
        }

        .hotel-ranking .rank-pos-1 { top: 60px;  left: 110px; }
        .hotel-ranking .rank-pos-2 { top: 380px; left: -50px; }
        .hotel-ranking .rank-pos-3 { top: 380px; left: 280px; }

        .hotel-ranking .ranking-title-overlay {
            top: 280px;
            left: 430px;
            transform: none;
            text-align: left;
        }

        /* レストランランキング */
        .restaurant-ranking .ranking-bg-circle {
            top: -10px;
            right: 0px;
            left: auto;
        }

        .restaurant-ranking .rank-pos-1 { top: -40px;  right: 120px; }
        .restaurant-ranking .rank-pos-2 { top: 280px;  right: 290px; }
        .restaurant-ranking .rank-pos-3 { top: 280px;  right: -40px; }

        .restaurant-ranking .ranking-title-overlay {
            top: 180px;
            right: 660px;
            left: auto;
            transform: none;
            text-align: right;
        }

        .ranking-title-overlay {
            position: absolute;
            font-size: 3.6rem;
            font-weight: 800;
            color: #333;
            letter-spacing: 2px;
            line-height: 1.4;
            z-index: 1;
            pointer-events: none;
            width: 180px;
        }

        /* ===== ランキングカード ===== */
        .premium-rank-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            transform-style: preserve-3d;
        }

        @keyframes fadeInUpCard {
            0%   { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-card {
            opacity: 0;
            animation: fadeInUpCard 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }

        .rank-pos-1 .premium-rank-card:hover,
        .rank-pos-2 .premium-rank-card:hover,
        .rank-pos-3 .premium-rank-card:hover {
            transform: translateY(-15px) rotateX(3deg);
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.18);
        }

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
            transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .premium-rank-card:hover .rank-image {
            transform: scale(1.1) translateX(10px);
        }

        .card-img-overlay {
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 40%, rgba(0,0,0,0.6) 100%);
            border-radius: 20px 20px 0 0;
        }

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
            font-family: 'Georgia', serif;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        .rank-1 .rank-num { color: #d4af37; }
        .rank-2 .rank-num { color: #8a8a8a; }
        .rank-3 .rank-num { color: #b08d57; }

        .card-city-premium {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

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
            100% { left: 125%; }
        }

        /* ===== リーセントポスト ===== */
        .recent-heading {
            position: relative;
            text-align: left;
            font-size: 100px;
            font-weight: 700;
            line-height: 0.9;
            color: rgba(102, 102, 102, 0.7);
            z-index: 0;
            pointer-events: none;
            margin-left: 5%;
        }

        .recent-subtext {
            text-align: left;
            max-width: 600px;
            margin-right: auto;
            margin-top: 40px;
            margin-left: 5%;
            font-size: 20px;
            line-height: 1.8;
            color: rgb(102, 102, 102);
            letter-spacing: 0.5px;
        }

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

        .post-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
            filter: brightness(0.9);
        }

        .post-slider {
            overflow: hidden;
            width: 100%;
            padding-bottom: 60px;
            -webkit-mask-image: linear-gradient(to right, transparent, black 12%, black 88%, transparent);
            mask-image: linear-gradient(to right, transparent, black 12%, black 88%, transparent);
        }

        .post-track {
            display: flex;
            gap: 15px;
            width: max-content;
            animation: scrollPosts 60s linear infinite;
        }

        .post-item {
            flex: 0 0 auto;
            width: 250px;
            padding-top: 20px;
        }

        .post-item:nth-child(odd)  .post-card { transform: rotate(-4deg); }
        .post-item:nth-child(even) .post-card { transform: rotate(3deg); }
        .post-item:nth-child(3n)   .post-card { transform: rotate(-6deg); }
        .post-item:nth-child(4n)   .post-card { transform: rotate(5deg); }

        .post-item:nth-child(6n+1) { margin-top: 20px; }
        .post-item:nth-child(6n+2) { margin-top: 0; }
        .post-item:nth-child(6n+3) { margin-top: 35px; }
        .post-item:nth-child(6n+4) { margin-top: 10px; }
        .post-item:nth-child(6n+5) { margin-top: 40px; }
        .post-item:nth-child(6n+6) { margin-top: 15px; }

        @keyframes scrollPosts {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
@endsection