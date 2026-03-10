<div class="container-fluid">
    @php
        $role_hotel = config('app.role_hotel');
    @endphp
    @if (Auth::user()->role_id == $role_hotel)
        <a class="navbar-brand" href="{{ route('hotel.home') }}"
            style="display: flex; align-items: center; height: 70px; overflow: hidden; vertical-align: middle;">
            <img src="{{ asset('images/Icon.png') }}"
                style="height: 180px; margin-top: -5px; margin-bottom: -5px; width: auto; object-fit: contain;">
        </a>
    @else
        <a class="navbar-brand" href="{{ route('restaurant.home') }}"
            style="display: flex; align-items: center; height: 70px; overflow: hidden; vertical-align: middle;">
            <img src="{{ asset('images/Icon.png') }}"
                style="height: 180px; margin-top: -5px; margin-bottom: -5px; width: auto; object-fit: contain;">
        </a>
    @endif

    <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @else
            @php
                $role_hotel = config('app.role_hotel');
            @endphp

            <li class="nav-item">
                @if (Auth::user()->role_id == $role_hotel)
                    <a href="{{ route('hotel.calendar') }}" class="nav-link">
                        <i class="fa-solid fa-bed"></i>
                    </a>
                @else
                    <a href="{{ route('restaurant.calendar') }}" class="nav-link">
                        <i class="fa-solid fa-utensils"></i>
                    </a>
                @endif
            </li>

            <li class="nav-item">
                @if (Auth::user()->role_id == $role_hotel)
                    <a href="{{ route('hotel.home') }}" class="nav-link">
                        <i class="fa-solid fa-house"></i>
                    </a>
                @else
                    <a href="{{ route('restaurant.home') }}" class="nav-link">
                        <i class="fa-solid fa-house"></i>
                    </a>
                @endif
            </li>
            <li class="nav-item">
                @if (Auth::user()->role_id == $role_hotel)
                    <a href="{{ route('hotel.roomOverview') }}" class="nav-link">
                        <i class="fa-solid fa-table"></i>
                    </a>
                @else
                    <a href="{{ route('restaurant.tableOverview') }}" class="nav-link">
                        <i class="fa-solid fa-table"></i>
                    </a>
                @endif
            </li>
            <li class="nav-item dropdown me-4">
                <a class="nav-link dropdown-toggle fw-bold text-dark px-3" data-bs-toggle="dropdown" href="#"
                    role="button" aria-expanded="false"></i> {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 210px;">
                    <div class="px-3 py-2">
                        <small class="text-uppercase text-muted fw-bold"
                            style="font-size: 0.65rem; letter-spacing: 0.5px;">Account</small>
                    </div>

                    <a href="{{ route('home') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2 text-dark">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="fw-bold">User Home</span>
                    </a>

                    <hr class="dropdown-divider my-2">

                    <a href="{{ route('logout') }}"
                        class="dropdown-item d-flex align-items-center py-2 rounded-2 text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                        <span class="fw-bold">{{ __('Logout') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
