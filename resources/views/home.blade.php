@extends('layouts.user')

@section('content')
    <div class="main-card justify-content-center mt-4">

        {{-- --------------- 
            トップメニュー 
        --------------- --}}
        <div class="d-flex justify-content-center p-3">

            {{-- ホテルのリンク --}}
            <a href="{{ route('user.hotels.index') }}" class="menu-btn menu-hotel text-decoration-none">
                <i class="fa-solid fa-bed"></i>
                <div>Hotel</div>
            </a>

            {{-- レストランのリンク --}}
            <a href="#" class="menu-btn menu-restaurant text-decoration-none">
                <i class="fa-solid fa-utensils"></i>
                <div>Restaurant</div>
            </a>

            {{-- ジプニーのリンク --}}
            <a href="{{ route('jeepney') }}" class="menu-btn menu-jeepney text-decoration-none">
                <i class="fa-solid fa-van-shuttle"></i>
                <div>Jeepney</div>
            </a>

            {{-- ポストのリンク --}}
            <a href="{{ route('user.posts.index') }}" class="menu-btn menu-mypage text-decoration-none">
                <i class="fa-solid fa-user"></i>
                <div>Post</div>
            </a>

        </div>

        {{-- --------------- 
            ホテル ランキング 
        --------------- --}}
        <div>
            <div>
                <h3 class="section-title">Hotel Ranking  <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
               
            </div>

            <div class="row justify-content-center g-2 mb-3">
                @foreach ($hotelRankings as $index => $hotel)
                    <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">

                        <div class="card rank-card">
                            <div class="rank-badge rank-{{ $index + 1 }}">
                                {{ $index + 1 }}
                            </div>

                            {{-- <img src="{{ $hotel->image_path ?? asset('images/no-image.png') }}" alt="{{ $hotel->name }}" class="rank-image"> --}}
                            <img src="{{ $hotel->image_path ? Storage::url($hotel->image_path) : asset('images/no-image.png') }}"
                                alt="{{ $hotel->name }}" class="rank-image"
                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                            <div class="card-body">
                                <a href="#" class="text-decoration-none text-dark">
                                    <h5 class="card-title">{{ $hotel->name }}</h5>
                                </a>
                                @php
                                    $rating = $hotel->star_rating;
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                @endphp
                                <p class="card-text text-warning">
                                    @for ($i = 1; $i < $fullStars; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    @endif
                                    <span class="text-muted ms-1">{{ number_format($rating, 1) }}</span>
                                </p>
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

        {{-- ---------------
            レストラン ランキング 
            --------------- --}}
        <div>
            <div>
                <h3 class="section-title">Restrant Ranking <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
                
            </div>

            <div class="row justify-content-center g-2 mb-3">
                @foreach ($restaurantRankings as $index => $restaurant)
                    <div class="col-6 col-md-3 col-sm-4 col-lg-2 d-flex justify-content-center">

                        <div class="card rank-card">
                            <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>

                            <img src="{{ $restaurant->image_path ?? asset('images/no-image.png') }}"
                                alt="{{ $restaurant->name }}" class="rank-image">

                            <div class="card-body">
                                <a href="#" class="card-link text-decoration-none text-dark">
                                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                                </a>
                                @php
                                    $rating = $restaurant->star_rating;
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
                                <p class="card-city">
                                    <i class="fa-solid fa-location-dot"></i> {{ $restaurant->city }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        {{-- -----------
        都市別ホテル 
        ----------------}}
        <div>
            @foreach ($hotelsByCity as $city => $hotels)
                <div>
                    <h3 class="section-title">{{ $city }}</h3>
                </div>

                <div class="d-flex justify-content-center flex-wrap gap-3 mb-3">
                    @foreach ($hotels as $index => $hotel)
                        <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                            <div class="card rank-card">
                                <img src="{{ $hotel->image_path ?? asset('images/no-image.png') }}"
                                    alt="{{ $hotel->name }}" class="rank-image">

                                <div class="card-body">
                                    <h5 class="card-title">{{ $hotel->name }}</h5>
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

        {{-- --------------- 
           ポスト 
            --------------- --}}
        <div>
            <div>
                <h3 class="section-title">Recent Posts <a href="{{ route('user.posts.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View More</a></h3>
                
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
                                        <form action="{{ route('user.like.destroy', $post->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="heat-btn">
                                               
                                                <i class="fa-solid fa-heart text-danger"></i>
                                            </button>
                                        </form>    
                                    @else
                                        <form action="{{ route('user.like.store', $post->id )}}" method="post">
                                            @csrf
                                            <button type="submit" class="heat-btn"><i class="fa-regular fa-heart"></i></button>

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


        {{-- ----------
        右固定サイド
        ------------ --}}
        <div class="right-fixed-panel">
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

        {{-- フッター --}}
        <footer class="site-footer">
            <div class="footer-inner">
                <div class="footer-columns">
                    <div class="footer-col">
                        <h4>サポート</h4>
                        <a href="#">カスタマーサポート</a>
                        <a href="#">お問い合わせ</a>
                        <a href="#">よくある質問</a>
                    </div>

                    <div class="footer-col">
                        <h4>このサイトについて</h4>
                        <a href="#">会社概要</a>
                        <a href="#">利用規則</a>
                        <a href="#">プライバシーポリシー</a>
                    </div>
                    <div class="footer-col">
                        <h4>お支払い方法</h4>
                        <div class="payment-icon">
                            <img src="{{ asset('/images/reservation-cards.png') }}">
                        </div>
                    </div>
                </div>
            </div>
            <p class="footer-copy">
                ©️2026 kredo POKECEBU
            </p>
        </footer>







        {{-- CSS --}}
        <style>
            /* 全カードの設定 */
            .main-card {
                background: #f5fbff;
                border-radius: 25px;
                padding-bottom: 20px;
                overflow: hidden;
            }

            /* メインメニュー */
            .menu-btn {
                width: 140px;
                height: 120px;
                border-radius: 25px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                color: #ffffff;
                font-weight: bold;
                box-shadow: 0 3px rgba(0, 0, 0, 0.1);
                margin: 10px;
            }

            .menu-restaurant {
                background: #fdbf79;
            }

            .menu-hotel {
                background: #8dbcda;
            }

            .menu-jeepney {
                background: #96ccb9;
            }

            .menu-mypage {
                background: #e9e3d3;
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
                box-shadow: 0 2px 6px rgba(0,0,0,0.10);
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

            /* フッター */
            .site-footer {
                background: #f7f8fa;
                margin: 80px;
                padding: 60px 0 30px;
            }

            .footer-inner {
                max-width: 1200px;
                margin: auto;
                padding: 0 20px;
            }

            .footer-columns {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 40px;
            }

            .footer-col h4 {
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 14px;
            }

            .footer-col a {
                display: block;
                font-size: 14px;
                color: #555;
                text-decoration: none;
                margin-bottom: 8px;
            }

            .footer-col a:hover {
                color: #000;
            }

            .payment-icon img {
                height: 26px;
                margin-right: 8px;
            }

            .footer-copy {
                text-align: center;
                font-size: 13px;
                color: #888;
                margin-top: 40px;
            }

            /* 右固定サイド */
            .right-fixed-panel {
                position: fixed;
                right: 24px;
                top: 140px;
                width: 300px;
                z-index: 50;
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            /* モバイルでは消す */
            @media (max-width: 992px) {
                .right-fixed-panel {
                    display: none;
                }
            }

            /* 天気予報 */
            .weather-card,
            .currency-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 16px;
                max-width: 320px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            }

            .weather-city {
                font-weight: bold;
                font-size: 16px;
            }

            .weather-main {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .temp {
                font-size: 32px;
                font-weight: bold;
            }

            /* 為替レート */

            .currency-title {
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 8px;
            }
        </style>
    @endsection
