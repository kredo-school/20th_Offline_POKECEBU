<div class="container-fluid">
    <a class="navbar-brand" href="/"
        style="display: flex; align-items: center; height: 70px; overflow: hidden; vertical-align: middle;">
        <img src="{{ asset('images/Icon.png') }}"
            style="height: 180px; margin-top: -5px; margin-bottom: -5px; width: auto; object-fit: contain;">
    </a>

    @auth
        <!-- 中央：Hotel〜FAQ -->
        <ul class="navbar-nav mx-auto d-flex flex-row gap-5">
            <li class="nav-item">
                <a href="{{ route('user.hotels.index') }}" class="nav-link text-center">
                    <i class="fa-solid fa-bed"></i>
                    <div>Hotel</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.restaurants.search') }}" class="nav-link text-center">
                    <i class="fa-solid fa-utensils"></i>
                    <div>Restaurant</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('jeepney.index') }}" class="nav-link text-center">
                    <i class="fa-solid fa-van-shuttle"></i>
                    <div>Jeepney</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.posts.index') }}" class="nav-link text-center">
                    <i class="fa-solid fa-user"></i>
                    <div>Post</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('faq.index') }}" class="nav-link text-center">
                    <i class="fa-regular fa-circle-question"></i>
                    <div>FAQ</div>
                </a>
            </li>
        </ul>
    @endauth

    <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item">
                <a class="nav-link fw-bold text-primary px-3" href="{{ route('login') }}">Login</a>
            </li>
        @else
            <li class="nav-item dropdown me-4">
                <a class="nav-link dropdown-toggle fw-bold text-dark px-3" data-bs-toggle="dropdown" href="#"
                    role="button" aria-expanded="false"></i> Hello! {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 210px;">
                    <div class="px-3 py-2">
                        <small class="text-uppercase text-muted fw-bold"
                            style="font-size: 0.65rem; letter-spacing: 0.5px;">Dashboard</small>
                    </div>

                    <a href="{{ route('user.mypage') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="fw-semibold">My Page</span>
                    </a>

                    @can('admin')
                        <a href="{{ route('admin.home') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2">
                            <div class="bg-dark bg-opacity-10 text-dark rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <span class="fw-semibold">Admin</span>
                        </a>
                    @endcan

                    @can('hotel')
                        <a href="{{ route('hotel.home') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-hotel"></i>
                            </div>
                            <span class="fw-semibold">Hotel</span>
                        </a>
                    @endcan

                    @can('restaurant')
                        <a href="{{ route('restaurant.home') }}"
                            class="dropdown-item d-flex align-items-center py-2 rounded-2">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <span class="fw-semibold">Restaurant</span>
                        </a>
                    @endcan

                    <hr class="dropdown-divider my-2 opacity-50">

                    <a href="{{ route('logout') }}"
                        class="dropdown-item d-flex align-items-center py-2 rounded-2 text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                        <span class="fw-semibold">{{ __('Logout') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
