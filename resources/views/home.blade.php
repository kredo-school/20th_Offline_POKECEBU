@extends('layouts.user')

@section('content')
    <div class="main-caod mt-4">

        {{-- --------------- 
            menu 
        --------------- --}}
        <div class="d-flex justify-content-around p-3">

            <a href="#" class="menu-btn menu-restaurant text-decoration-none">
                <i class="fa-solid fa-utensils"></i>
                <div>Restaurant</div>
            </a>

            <a href="#" class="menu-btn menu-hotel text-decoration-none">
                <i class="fa-solid fa-bed"></i>
                <div>Hotel</div>
            </a>

            <a href="{{ route('jeepney') }}" class="menu-btn menu-jeepney text-decoration-none">
                <i class="fa-solid fa-van-shuttle"></i>
                <div>Jeepney</div>
            </a>

            <a href="#" class="menu-btn menu-mypage text-decoration-none">
                <i class="fa-solid fa-user"></i>
                <div>My Page</div>
            </a>

        </div>
        {{-- --------------- 
            hotel Ranking 
        --------------- --}}
        <div class="section-title">Hotel Ranking</div>

        <div class="px-3">
            <div class="row g-2 mb-3 d-flex">
                {{-- @foreach ($hotelRankings as $index => $hotel)
                <div class="col-4">
                    <div class="card ramk-card text-center me-3" style="width: 250px;">
                        <div class="ramk-badge">{{ $index + 1 }}</div>
                        <img src="{{ $hotel->image }}" alt="" class="card-img-top image-fluid rounded mb-1" height="150px" width="10px">
     
                        <div class="card-body">
                            <a href="" class="card-link text-decoration-none fw-bold small text-dark"><h4 class="card-subtitle">{{ $hotel->name }}</h4></a>
                            <p class="card-text text-warning">★★★★★</p>
                        </div>

                    </div>       
                </div> 
                @endforeach --}}


                {{-- あとで消す-ここから --}}
                <div class="card me-3" style="width: 250px;">
                    <div class="rank-badge">1</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="10px">

                    <div class="card-body">
                        <a href="" class="card-link text-decoration-none text-dark">
                            <h5 class="card-subtitle">SUGOI hotel</h5>
                        </a>
                        <p class="card-text text-warning">★★★★★</p>

                    </div>
                </div>
                <div class="card me-3" style="width: 250px;">
                    <div class="rank-badge">2</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="100px">

                    <div class="card-body">
                        <a href="" class="card-link text-decoration-none text-dark">
                            <h5 class="card-subtitle">TABUN condominium</h5>
                        </a>
                        <p class="card-text text-warning">★★★★</p>

                    </div>
                </div>
                <div class="card" style="width: 250px;">
                    <div class="rank-badge">3</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="100px">

                    <div class="card-body">
                        <a href="" class="card-link text-decoration-none text-dark">
                            <h5 class="card-subtitle">YABAI motel</h5>
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
                Restrant Ranking 
                --------------- --}}
            <div class="section-title">Restrant Ranking</div>

            <div class="row g-2 d-flex">
                {{-- @foreach ($restrantRankings as $index => $restrant)
                <div class="col-4">
                    <div class="card ramk-card text-center" style="width: 250px;">
                        <div class="ramk-badge">{{ $index + 1 }}</div>
                        <img src="{{ $restrant->image }}" alt="" class="card-img-top image-fluid rounded mb-1" height="150px" width="10px">
     
                        <div class="card-body">
                            <a href="" class="card-link text-decoration-none text-dark fw-bold small"><h5 class="card-subtitle">{{ $restrant->name }}</h5></a>
                            <p class="card-text text-warning">★★★★★</p>
                        </div>
                    </div>     
                </div>
                @endforeach --}}

                {{-- あとで消す-ここから --}}
                <div class="card ramk-card text-center me-3" style="width: 250px;">
                    <div class="rank-badge">1</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="10px">

                    <div class="card-body">
                        <a href="" class="card-link text-decoration-none text-dark">
                            <h5 class="card-subtitle">SASUGA restaurant</h5>
                        </a></a>
                        <p class="card-text text-warning">★★★★★</p>
                    </div>
                </div>

                <div class="card ramk-card text-center me-3" style="width: 250px;">
                    <div class="rank-badge">2</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="100px">

                    <div class="card-body">
                        <a href="" class="card-link text-decoration-none text-dark">
                            <h5 class="card-subtitle">KITTO cafe</h5>
                        </a>
                        <p class="card-text text-warning">★★★★</p>
                    </div>
                </div>

                <div class="card ramk-card text-center me-3" style="width: 250px;">
                    <div class="rank-badge">3</div>
                    <img src="#" alt="" class="card-img-top" height="150px" width="100px">

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
            Post 
            --------------- --}}
            <div class="section-title">Recent Posts</div>

            <div class="px-3 pb-4">
                {{-- @foreach ($posts as $post)
                    <div class="post-card mb-2">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $post->user->avater }}" alt="" class="rounded-circle me-2" width="35" height="35">
                            <div>
                                <div class="fw-bold small">{{ $post->user->name }}</div>
                                <div class="text-muted small">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                     </div>
                    <img src="{{ $post->image }}" alt="" class="imag-fluid rounded mb-2">
                    <div class="small">{{ $post->sontent }}</div>
                </div>
                @endforeach --}}
            </div>

        </div>






        {{-- CSS --}}
        <style>
            /* All Card */
            .main-card {
                max-width: 400px;
                margin: auto;
                background: #f5fbff;
                border-radius: 25px;
                overflow: hidden;
            }

            /* Menu */
            .menu-btn {
                width: 140px;
                height: 100px;
                border-radius: 25px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                color: #fff;
                font-weight: bold;
                box-shadow: 0 3px rgba(0, 0, 0, 0.1);
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

            /* Section Card */
            .section-title {
                text-align: center;
                color: #4fa3d1;
                font-weight: bold;
                font-size: 30px;
                margin: 15px 0 10px;
            }

            /* Ranking */
            .rank-card {
                background: #fff;
                border-radius: 15px;
                padding: 8px;
                position: relative;
            }

            .rank-badge {
                position: absolute;
                top: -8px;
                left: -8px;
                background: #ffd36b;
                border-radius: 50%;
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                font-weight: bold;
            }

            /* POST */
            .post-card {
                background: #fff;
                border-radius: 15px;
                padding: 10px;
            }
        </style>
    @endsection
