<div class="container">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('images/Icon.png') }}" style="height:80px;">
    </a>

    <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @else
            <li class="nav-item">
                <a href="{{ route('faq.index') }}" class="nav-link">
                    <i class="fa-regular fa-circle-question"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div id="user-menu" class="create-menu" style="right: 0;">

                        @can('admin')
                            <a href="{{ route('admin.home') }}" class="create-item">
                                <i class="fa-solid fa-user-gear me-2"></i>Admin
                            </a>
                        @endcan

                        @can('hotel')
                            <a href="{{ route('hotel.home') }}" class="create-item">
                                <i class="fa-solid fa-user-gear me-2"></i>Hotel
                            </a>
                        @endcan

                        @can('restaurant')
                            <a href="{{ route('restaurant.home') }}" class="create-item">
                                <i class="fa-solid fa-user-gear me-2"></i>Restaurant
                            </a>
                        @endcan

                        <a href="{{ route('logout') }}" class="create-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        @endguest
    </ul>
</div>
