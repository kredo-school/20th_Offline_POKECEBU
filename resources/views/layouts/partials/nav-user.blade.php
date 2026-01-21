<div class="container">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('images/Icon.png') }}" style="height:80px;">
    </a>

    <ul class="navbar-nav ms-auto">
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
            </li>
        @endguest
    </ul>
</div>