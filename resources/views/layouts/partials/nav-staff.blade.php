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

            <li class="nav-item dropdown me-3">
                @if (Auth::user()->role_id == $role_hotel)
                    @php
                        $lastCheck = session('last_cancellation_check', \Carbon\Carbon::parse('2000-01-01'));
                        $unreadCancellations = \App\Models\HotelReservation::where('hotel_id', Auth::id())
                            ->where('status_id', 5)
                            ->where('updated_at', '>', $lastCheck)
                            ->count();
                    @endphp
                    <a class="nav-link position-relative" href="#" id="cancellationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:2px;">
                        <i class="fa-solid fa-bell fs-5 text-dark"></i>
                        @if($unreadCancellations > 0)
                            <span class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                {{ $unreadCancellations }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2" aria-labelledby="cancellationDropdown" style="width: 320px;">
                        <li><h6 class="dropdown-header fw-bold text-uppercase" style="font-size:0.7rem;">Notifications</h6></li>
                        @if($unreadCancellations > 0)
                            <li>
                                <a class="dropdown-item py-3 text-wrap" href="{{ route('hotel.cancellation.markRead') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3 d-flex justify-content-center align-items-center" style="width:40px; height:40px;">
                                            <i class="fa-solid fa-ban fs-6"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $unreadCancellations }} New Cancellation(s)</strong>
                                            <small class="text-muted" style="font-size:0.75rem;">Click to mark as read and view details</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @else
                            <li><span class="dropdown-item text-muted py-3"><i class="fa-regular fa-bell-slash me-2"></i>No new notifications</span></li>
                        @endif
                    </ul>
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

                    {{-- 共通のホーム --}}
                    <a href="{{ route('home') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2 text-dark">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="fw-bold">User Home</span>
                    </a>

                    {{-- 修正ポイント：role_id と $role_hotel で判定する --}}
                    @if (Auth::user()->role_id == $role_hotel)
                        {{-- ホテルの場合 --}}
                        <a href="{{ route('hotel.staff.mypage.hotel') }}"
                            class="dropdown-item d-flex align-items-center py-2 rounded-2 text-dark">
                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-hotel"></i>
                            </div>
                            <span class="fw-bold">Hotel Profile</span>
                        </a>
                    @else
                        {{-- レストランの場合 --}}
                        <a href="{{ route('restaurant.staff.mypage.restaurant') }}"
                            class="dropdown-item d-flex align-items-center py-2 rounded-2 text-dark">
                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <span class="fw-bold">Restaurant Profile</span>
                        </a>
                    @endif

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
