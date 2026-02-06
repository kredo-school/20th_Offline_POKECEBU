@extends('layouts.user')

@section('content')
    <div class="main-card justify-content-center mt-4">

        {{-- --------------- 
            トップメニュー 
        --------------- --}}
        <div class="d-flex justify-content-center p-3">

            {{-- レストランのリンク --}}
            <a href="#" class="menu-btn menu-restaurant text-decoration-none">
                <i class="fa-solid fa-utensils"></i>
                <div>Restaurant</div>
            </a>

            {{-- ホテルのリンク --}}
            <a href="#" class="menu-btn menu-hotel text-decoration-none">
                <i class="fa-solid fa-bed"></i>
                <div>Hotel</div>
            </a>

            {{-- ジプニーのリンク --}}
            <a href="{{ route('jeepney') }}" class="menu-btn menu-jeepney text-decoration-none">
                <i class="fa-solid fa-van-shuttle"></i>
                <div>Jeepney</div>
            </a>

            {{-- マイページのリンク --}}
            <a href="#" class="menu-btn menu-mypage text-decoration-none">
                <i class="fa-solid fa-user"></i>
                <div>My Page</div>
            </a>

        </div>
        {{-- --------------- 
            ホテル ランキング 
        --------------- --}}
        <div class="section-title">Hotel Ranking</div>

        <div class="container px-3">
            <div class="d-flex justify-content-center flex-wrap gap-3 mb-3">
                {{-- @foreach ($hotelRankings as $index => $hotel)
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card rank-card">
                        <!-- 順位バッジ-->
                        <div class="rank-badge rank-{{ $index + 1 }}">
                            {{ $index + 1 }}
                        </div>
                        <ホテルの画像＞
                        <img src="#" alt="{{ $hotel->name }}" class="card-img-top rank-image">
     
                        
                        <div class="card-body">
                            <詳細リンク＞
                            <a href="{{ route('hotels.show',$hotel->id) }}" class="text-decoration-none text-dark">
                                <h5 class="card-title">{{ $hotel->name }}</h5>
                            </a>

                            <⭐︎評価＞
                            <p class="card-text text-warning">
                                {{ str_repeat('★' $hotel->rating) }}
                            </p>
                        </div>

                    </div>       
                </div> 
                @endforeach --}}


                {{-- あとで消す-ここから --}}


                <div class="card rank-card">
                    {{--  順位バッジ --}}
                    <div class="rank-badge rank-1">
                        1
                    </div>
                    {{-- ホテルの画像 --}}
                    <img src="{{ asset('images/hotel-img1.jpg') }}" alt="" class="card-img-top rank-image">

                    <div class="card-body">
                        {{-- <詳細リンク＞ --}}
                        <a href="#" class="text-decoration-none text-dark">
                            <h5 class="card-title">SUGOI hotel</h5>
                        </a>

                        {{-- ⭐︎評価 --}}
                        <p class="card-text text-warning">
                            ★★★★★
                        </p>
                    </div>

                </div>


                <div class="card rank-card">
                    {{--  順位バッジ --}}
                    <div class="rank-badge rank-2">
                        2
                    </div>
                    {{-- ホテルの画像 --}}
                    <img src="{{ asset('images/hotel-img2.jpg') }}" alt="" class="card-img-top rank-image">

                    <div class="card-body">
                        {{-- <詳細リンク＞ --}}
                        <a href="#" class="text-decoration-none text-dark">
                            <h5 class="card-title">TABUN condominium</h5>
                        </a>

                        {{-- ⭐︎評価 --}}
                        <p class="card-text text-warning">
                            ★★★★
                        </p>
                    </div>


                </div>

                <div class="card rank-card">
                    {{--  順位バッジ --}}
                    <div class="rank-badge rank-3">
                        3
                    </div>
                    {{-- ホテルの画像 --}}
                    <img src="{{ asset('images/hotel-img3.jpg') }}" alt="" class="card-img-top rank-image">

                    <div class="card-body">
                        {{-- <詳細リンク＞ --}}
                        <a href="#" class="text-decoration-none text-dark">
                            <h5 class="card-title">YABAI motel</h5>
                        </a>

                        {{-- ⭐︎評価 --}}
                        <p class="card-text text-warning">
                            ★★
                        </p>
                    </div>
                </div>

            </div>
            {{-- あとで消す-ここまで --}}

            <div class="text-center mt-2">
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View More</a>
            </div>

        </div>

        {{-- ---------------
                レストラン　ランキング 
                --------------- --}}
        <div class="section-title">Restrant Ranking</div>

        <div class="row g-2 d-flex justify-content-center">
            {{-- @foreach ($restrantRankings as $index => $restrant)
                <div class="col-4">
                    <div class="card rank-card text-center" style="width: 250px;">
                        <div class="rank-badge">{{ $index + 1 }}</div>
                        <img src="{{ $restrant->image }}" alt="" class="card-img-top image-fluid rounded mb-1" height="150px" width="10px">
     
                        <div class="card-body">
                            <a href="" class="card-link text-decoration-none text-dark fw-bold small"><h5 class="card-subtitle">{{ $restrant->name }}</h5></a>
                            <p class="card-text text-warning">★★★★★</p>
                        </div>
                    </div>     
                </div>
                @endforeach --}}

            {{-- あとで消す-ここから --}}
            <div class="card rank-card me-3" style="width: 250px;">
                <div class="rank-badge rank-1">1</div>
                <img src="{{ asset('images/food-img1.jpg') }}" alt="" class="card-img-top" height="150px"
                    width="10px">

                <div class="card-body">
                    <a href="" class="card-link text-decoration-none text-dark">
                        <h5 class="card-subtitle">SASUGA restaurant</h5>
                    </a></a>
                    <p class="card-text text-warning">★★★★★</p>
                </div>
            </div>

            <div class="card rank-card me-3" style="width: 250px;">
                <div class="rank-badge rank-2">2</div>
                <img src="{{ asset('images/food-img2.jpg') }}" alt="" class="card-img-top" height="150px"
                    width="100px">

                <div class="card-body">
                    <a href="" class="card-link text-decoration-none text-dark">
                        <h5 class="card-subtitle">KITTO cafe</h5>
                    </a>
                    <p class="card-text text-warning">★★★★</p>
                </div>
            </div>

            <div class="card rank-card me-3" style="width: 250px;">
                <div class="rank-badge rank-3">3</div>
                <img src="{{ asset('images/food-img3.jpg') }}" alt="" class="card-img-top" height="150px"
                    width="100px">

                <div class="card-body">
                    <a href="" class="card-link text-decoration-none text-dark">
                        <h5 class="card-subtitle">MAJIDE gohan</h5>
                    </a>
                    <p class="card-text text-warning">★★</p>
                </div>
            </div>
            {{-- あとで消す-ここまで --}}

            <div class="text-center mt-2">
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View More</a>
            </div>
        </div>


        {{-- --------------- 
                ポスト 
            --------------- --}}
        <div class="section-title">Recent Posts</div>
        <div class="px-3 pb-4">
            @if ($home_posts->isNotEmpty())
                <div class="row">
                    @foreach ($home_posts as $post)
      <div class="col-md-6 col-lg-4 mb-4">
        <a href="{{ route('userpage.posts.show',$post->id) }}" class="post-link">
        <div class="card rank-card h-100">
          <img src="{{ $post->images->first()->image }}" alt="Post Image" class="card-img-top img-fluid">
          <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            
            <p class="post-user mb-1">{{ $post->user->name }}</p>
            
            <p class="post-date">{{ $post->created_at->format('M d, Y') }}</p>
            <div class="mb-2">
              {{-- @foreach ($post->categoryPost as $category_post)
                <span class="badge bg-secondary">{{ $category_post->category->name }}</span>
              @endforeach --}}
              {{-- @if (empty($post->categoryPost))
                <span class="badge bg-dark">Uncategorized</span>
              @endif --}}
            </div>
            <div>
              {{-- <i class="far fa-heart"></i> {{ $post->likes->count() }} --}}
            </div>
            {{-- @if ($post->comments->isNotEmpty())
              <ul class="list-group mt-2">
                @foreach ($post->comments as $comment)
                  <li class="list-group-item border-0 p-0 mb-1">
                    <span class="fw-bold">{{ $comment->user->name }}</span>:
                    <span>{{ $comment->body }}</span>
                  </li>
                @endforeach
              </ul>
            @endif --}}
          </div>
        </div>
        </a>
      </div>
    @endforeach
                </div>
            @else
                <h3 class="text-muted text-center">No Posts Yet</h3>
            @endif
        </div>
        <div class="text-center mt-2">
                <a href="{{ route('userpage.posts.index',$post->post) }}" class="btn btn-sm btn-outline-primary rounded-pill">View More</a>
            </div>

    </div>






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
            width: 250px;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            padding: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }

        .rank-card:hover {
            transform: translateY(-8px) scale(1.03);
        }

        .rank-image {
            height: 150px;
            object-fit: cover;
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
            background: #fff;
            border-radius: 15px;
            padding: 10px;
        }

        .post-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
    </style>
@endsection
