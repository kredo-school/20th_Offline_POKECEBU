@extends('layouts.user')

@section('content')
    {{-- 動画ヒーロー --}}
    <div class="hero-video">
        <video autoplay muted loop playsinline class="hero-bg-video">
            <source src="{{ asset('videos/home-beach.mp4') }}" type="video/mp4">
        </video>

        <div class="hero-overlay">
            <h1 class="hero-title">
                <span class="mb-4 hero-line">Pack Your</span><br>
                <span class="mb-4 hero-line">Cebu Trip</span><br>
                <span class="mb-2 hero-line">In A Pocket</span>
            </h1>
            <p class="hero-sub">Ready to explore the island?</p>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-4">
            <!-- メイン -->
            <div class="col-lg-9">
                <div class="main-card">
                    <div class="row g-3 p-3 pt-0">
                        <div class="col-12 mb-2">
                            <a href="{{ route('user.hotels.index') }}" class="menu-btn menu-hotel text-decoration-none">
                                <i class="fa-solid fa-bed"></i>
                                <div class="menu-text-wrapper">
                                    <div class="menu-title">Find Your Stay</div>
                                    <div class="menu-subtitle">Experience comfort in Cebu</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 mb-2">
                            <a href="#" class="menu-btn menu-restaurant text-decoration-none">
                                <i class="fa-solid fa-utensils"></i>
                                <div class="menu-text-wrapper">
                                    <div class="menu-title">Dine & Savor</div>
                                    <div class="menu-subtitle">Taste the local flavors</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 mb-2">
                            <a href="{{ route('jeepney') }}" class="menu-btn menu-jeepney text-decoration-none">
                                <i class="fa-solid fa-van-shuttle"></i>
                                <div class="menu-text-wrapper">
                                    <div class="menu-title">Route & Ride</div>
                                    <div class="menu-subtitle">Check numbers and destinations</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 mb-2">
                            <a href="{{ route('user.posts.index') }}" class="menu-btn menu-mypage text-decoration-none">
                                <i class="fa-solid fa-user"></i>
                                <div class="menu-text-wrapper">
                                    <div class="menu-title">Share Your Cebu</div>
                                    <div class="menu-subtitle">Connect through your stories</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- ---------------ホテル ランキング--------------- --}}
                    <div>
                        <div>
                            <h3 class="section-title">Hotel Ranking <a href="#"
                                    class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
                        </div>

                        <div class="row justify-content-center g-2 mb-3">
                            @foreach ($hotelRankings as $index => $hotel)
                                <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">
                                    <div class="card rank-card">

                                        {{-- お気に入り --}}
                                        <div class="post-like">
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

                                        {{-- ランキングバッジ --}}
                                        <div class="rank-badge rank-{{ $index + 1 }}">
                                            {{ $index + 1 }}
                                        </div>

                                        <img src="{{ $hotel->image_path ? Storage::url($hotel->image_path) : asset('images/no-image.png') }}"
                                            alt="{{ $hotel->name }}" class="rank-image"
                                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                                        <div class="rank-body">
                                            <a href="{{ route('user.hotels.detail', $hotel->id) }}" class="rank-link">
                                                <h5 class="card-title">{{ $hotel->name }}</h5>
                                            </a>

                                            {{-- 星 --}}
                                            <div class="rank-star">
                                                @php
                                                    $rating = $hotel->star_rating;
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                @endphp
                                                <p class="card-text text-warning">
                                                    @for ($i = 1; $i <= $fullStars; $i++)
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
                    </div>

                    {{-- ---------------レストラン ランキング--------------- --}}
                    <div>
                        <div>
                            <h3 class="section-title">Restrant Ranking <a href="#"
                                    class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
                        </div>

                        <div class="row justify-content-center g-2 mb-3">
                            @foreach ($restaurantRankings as $index => $restaurant)
                                <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">
                                    <div class="card rank-card">

                                        {{-- お気に入り --}}
                                        <div class="post-like">
                                            @if ($restaurant->isFavorited())
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
                                                    action="{{ route('user.favorite.store', ['restaurant', $restaurant->id]) }}"
                                                    class="favorite-form">
                                                    @csrf
                                                    <button type="button" class="btn heat-btn">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>

                                        <img src="{{ $restaurant->image_path ?? asset('images/no-image.png') }}"
                                            alt="{{ $restaurant->name }}" class="rank-image">

                                        <div class="rank-body">
                                            <a href="{{ route('user.restaurants.detail', $restaurant->id) }}" class="rank-link">
                                                <h5 class="card-title">{{ $restaurant->name }}</h5>
                                            </a>
                                            <div class="rank-star">
                                                @php
                                                    $rating = $restaurant->star_rating;
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                @endphp
                                                <p class="card-text text-warning">
                                                    @for ($i = 1; $i <= $fullStars; $i++)
                                                        <i class="fa-solid fa-star"></i>
                                                    @endfor
                                                    @if ($halfStar)
                                                        <i class="fa-solid fa-star-half-stroke"></i>
                                                    @endif
                                                    <span class="text-muted ms-1">{{ number_format($rating, 1) }}</span>
                                                </p>
                                            </div>
                                            <p class="card-city">
                                                <i class="fa-solid fa-location-dot"></i> {{ $restaurant->city }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- -----------都市別ホテル-------------- --}}
                    <div>
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
                    </div>

                    {{-- ---------------ポスト--------------- --}}
                    <div>
                        <div>
                            <h3 class="section-title">Recent Posts <a href="{{ route('user.posts.index') }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
                        </div>

                        <div class="row justify-content-center g-2 mb-3">
                            @if ($home_posts->isNotEmpty())
                                @foreach ($home_posts as $post)
                                    <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">
                                        <a href="{{ route('user.posts.show', $post->id) }}" class="post-card">
                                            <img src="{{ $post->images->first()->image }}" alt="Post Image">

                                            {{-- ハート --}}
                                            <div class="post-like">
                                                @if ($post->isliked())
                                                    <form method="POST" action="{{ route('user.like.destroy', $post->id) }}"
                                                        class="favorite-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn heat-btn">
                                                            <i class="fa-solid fa-heart text-danger"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('user.like.store', $post->id) }}"
                                                        class="favorite-form">
                                                        @csrf
                                                        <button type="button" class="btn heat-btn">
                                                            <i class="fa-regular fa-heart"></i>
                                                        </button>
                                                @endif
                                            </div>

                                            {{-- テキスト --}}
                                            <div class="post-overlay">
                                                <h5 class="post-title">{{ $post->title }}</h5>
                                                <p class="post-user mb-1">
                                                    <i class="fa-regular fa-user"></i>{{ $post->user->name }}
                                                </p>
                                                <p class="post-date">
                                                    {{ $post->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <h3 class="text-muted text-center">No Posts Yet</h3>
                            @endif
                        </div>

                        <div class="post-tags">
                            <h3 class="section-title">人気タグ</h3>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                @foreach ($popularTags as $tag)
                                    <a href="{{ route('user.tags.show', $tag->name) }}" class="tag-badge">
                                        #{{ $tag->name }}({{ $tag->posts_count }})
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- サイド -->
            <div class="col-lg-3">
                <div class="side-panel">
                    {{-- 日付・時刻カード --}}
                    <div class="datetime-card mb-3">
                        <div class="date-label" id="current-date">--/--/--</div>
                        <div class="time-label" id="current-time">00:00</div>
                    </div>
                    {{-- 天気予報 --}}
                    <div class="weather-card">
                        <div class="weather-city">Cebu </div>
                        <div class="weather-main">
                            @if (isset($weather['weather'][0]['icon']))
                                <img src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png"
                                    alt="weather">
                            @endif
                            <div class="temp">{{ round($weather['main']['temp']) }}°C</div>
                        </div>
                        <div class="weather-desc">
                            {{ $weather['weather'][0]['description'] }}
                        </div>
                    </div>
                    <br>

                    {{-- 為替レート --}}
                    <div class="currency-card">
                        <div class="currency-title">為替レート</div>
                        @if ($rate && $rate > 0)
                            <p>1円 = {{ number_format($rate, 4) }} PHP</p>
                            <p>1ペソ≒ {{ number_format(1 / $rate, 2) }} 円</p>
                        @else
                            <p>レート取得中…</p>
                        @endif
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
            // (そのまま)
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

                // セブ島（フィリピン）の時間に合わせてフォーマット
                const options = { timeZone: 'Asia/Manila' };

                // 日付を表示 (例: MAR 04, 2026)
                const dateStr = now.toLocaleDateString('en-US', {
                    ...options, month: 'short', day: '2-digit', year: 'numeric'
                }).toUpperCase();

                // 時刻を表示 (例: 17:35)
                const timeStr = now.toLocaleTimeString('en-US', {
                    ...options, hour: '2-digit', minute: '2-digit', hour12: false
                });

                // HTML要素に反映（IDで指定）
                const dateElement = document.getElementById('current-date');
                const timeElement = document.getElementById('current-time');

                if (dateElement) dateElement.textContent = dateStr;
                if (timeElement) timeElement.textContent = timeStr;
            }

            // 1秒ごとに実行して時計を動かす
            setInterval(updateDateTime, 1000);
            // ページを開いた瞬間にも一度実行（1秒待たせないため）
            updateDateTime();
        });
    </script>


    {{-- CSS --}}
    <style>
        .hero-video {
            position: relative;
            width: 100%;
            height: 480px;
            overflow: hidden;
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

        /* 黒レイヤー */
        .hero-video::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.1);
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
            font-size: 16px;
            border-left: 3px solid #fff;
            padding-left: 15px;
        }

        /* メインメニュー */
        /* 既存の .menu-btn に追加・修正 */
        /* --- 共通設定（既存のものを修正） --- */
        .menu-btn {
            width: 100%;
            height: 160px;
            /* border-radius: 28px; ←これは削除 */
            border-radius: 0;
            /* 一度四角にする */
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
            /* 最終的に元の位置へ */
            pointer-events: auto;
        }

        /* ホバー時の浮き上がり（共通） */
        .menu-btn.show:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* --- 個別背景オーバーレイ（共通化） --- */
        /* 全ての menu-btn にオーバーレイをかける */
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
            /* 背景に馴染ませつつクッキリ */
        }

        .menu-title {
            font-size: 26px;
            /* 気持ち大きく */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            /* 少し広げるのが今のトレンド */
            margin-bottom: 2px;
        }

        .menu-subtitle {
            font-size: 14px;
            font-weight: 300;
            /* 細めのフォントウェイトがあれば最適 */
            letter-spacing: 0.05em;
            opacity: 0.9;
        }

        /* --- 共通：アイコンの基本設定 --- */
        .menu-btn i {
            font-size: 42px;
            margin-bottom: 15px;
            opacity: 0.9;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            /* 弾むような動き */
        }

        /* --- 左から組 (Hotel, Jeepney) のホバー --- */
        .menu-hotel:hover i,
        .menu-jeepney:hover i {
            /* 右に10度傾けながら、少し大きく */
            transform: scale(1.15) rotate(10deg);
        }

        /* --- 右から組 (Restaurant, Post) のホバー --- */
        .menu-restaurant:hover i,
        .menu-mypage:hover i {
            /* 左に10度傾けながら、少し大きく */
            transform: scale(1.15) rotate(-10deg);
        }

        /* 初期状態から少しだけ傾けておく */
        .menu-hotel i,
        .menu-jeepney i {
            transform: rotate(-5deg);
            /* 出てきた時はちょっと左に傾いている */
        }

        .menu-restaurant i,
        .menu-mypage i {
            transform: rotate(5deg);
            /* 出てきた時はちょっと右に傾いている */
        }

        /* --- 【左から生える組】Hotel, Jeepney --- */
        .menu-hotel,
        .menu-jeepney {
            /* 左側の上下は0、右側の上下は28px */
            border-radius: 0 150px 150px 0;

            /* 初期位置：左に隠す */
            transform: translateX(-100px);

            /* 画面左端にくっつけるための調整（Bootstrapのpaddingを相殺） */
            margin-left: -1rem;
            /* rowのpadding分だけ左にずらす（調整してください） */
            width: calc(100% + 1rem);
            /* ずらした分、幅を広げる */
        }

        /* --- 【右から生える組】Restaurant, Post --- */
        .menu-restaurant,
        .menu-mypage {
            /* 左側の上下は28px、右側の上下は0 */
            border-radius: 150px 0 0 150px;

            /* 初期位置：右に隠す */
            transform: translateX(100px);

            /* 画面右端にくっつけるための調整 */
            margin-right: -1rem;
            /* rowのpadding分だけ右にずらす */
            width: calc(100% + 1rem);
            /* ずらした分、幅を広げる */
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

        /* セクション */
        .section-title {
            text-align: center;
            color: #4fa3d1;
            font-weight: bold;
            font-size: 28px;
            margin: 40px 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .section-title::before,
        .section-title::after {
            content: "";
            flex: 1;
            height: 2px;
            background: #b5dbf0;
            max-width: 80px;
        }

        /* ランキング */
        .rank-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3 / 3.8;
            width: 100%;
            max-width: 260px;
        }

        .rank-card:hover img {
            transition: transform 0.4s;
            transform: scale(1.03);
        }

        .rank-image {
            width: 100%;
            height: 100%;
            min-height: 200px;
            object-fit: cover;
        }

        .rank-card .card-title {
            font-size: 18px;
        }

        .rank-card .card-text,
        .rank-card .card-price {
            font-size: 13px;
        }

        .rank-card p {
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .rank-link {
            text-decoration: none;
            color: #333;
        }

        /* ランキングバッジ（共通） */
        .rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #fff;
            border: 1px solid white;
            z-index: 10;
        }

        /* ランキングバッジ（順位） */
        .rank-1 {
            background: gold;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }

        .rank-2 {
            background: silver;
            box-shadow: 0 0 10px rgba(192, 192, 192, 0.8);
        }

        .rank-3 {
            background: #cd7f32;
            box-shadow: 0 0 10px rgba(205, 127, 50, 0.8);
        }

        /* POST */
        .post-card {
            position: relative;
            display: block;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3 / 4.2;
            width: 100%;
            max-width: 260px;
            color: #ffffff;
            text-decoration: none;
        }

        .post-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }

        /* テキスト */
        .post-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 16px;
            z-index: 1;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.6),
                    rgba(0, 0, 0, 0));
            width: 100%;
        }

        .post-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .post-user {
            font-size: 13px;
        }

        /* ハート */
        .heat-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 2;
            background: #ffffff;
            color: #333;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.10);
            display: grid;
            place-items: center;
        }


        .post-card:hover img {
            transform: scale(1.05);
        }

        .tag-badge {
            text-decoration: none;
            display: inline-block;
            padding: 4px 10px;
            margin: 2px;
            font-size: 12px;
            border-radius: 20px;
            background: #e0f2ff;
            color: #0077cc;
            font-weight: 600;
        }


        /* 右固定サイド全体のレイアウト */
        .right-fixed-panel {
            position: fixed;
            right: 24px;
            top: 140px;
            width: 260px;
            /* 少しスリムに */
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* モバイルでは非表示 */
        @media (max-width: 992px) {
            .right-fixed-panel {
                display: none;
            }
        }

        /* 共通カードスタイル（グラスモーフィズム） */
        .datetime-card,
        .weather-card,
        .currency-card {
            background: rgba(255, 255, 255, 0.15);
            /* 透明度のある白 */
            backdrop-filter: blur(12px);
            /* 背景をぼかす */
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            /* メニューボタンに合わせて丸みを強く */
            padding: 24px;
            color: rgb(113, 111, 111);
            /* 文字は白 */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* 縁取りでクッキリさせる */
            transition: transform 0.3s ease;
        }

        .datetime-card:hover,
        .weather-card:hover,
        .currency-card:hover {
            transform: translateY(-5px);
            /* ホバーで少し浮かす */
        }

        /* 日付・時刻 */
        .date-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .time-label {
            font-size: 48px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -1px;
        }

        /* 天気予報 */
        .weather-city {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .weather-main {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .weather-main img {
            width: 60px;
            /* アイコンを少し強調 */
            margin-left: -10px;
        }

        .temp {
            font-size: 36px;
            font-weight: 800;
        }

        .weather-desc {
            font-size: 12px;
            text-transform: capitalize;
            opacity: 0.9;
        }

        /* 為替レート */
        .currency-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 8px;
        }

        .currency-card p {
            margin: 0;
            font-size: 15px;
            font-weight: 500;
            line-height: 1.6;
        }
    </style>
@endsection