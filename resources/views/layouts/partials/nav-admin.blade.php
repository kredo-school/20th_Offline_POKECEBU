<div class="container-fluid">
    <a class="navbar-brand" href="/admin" style="display: flex; align-items: center; height: 70px; overflow: hidden; vertical-align: middle;">
        <img src="{{ asset('images/Icon.png') }}" style="height: 180px; margin-top: -5px; margin-bottom: -5px; width: auto; object-fit: contain;">
    </a>

    <ul class="navbar-nav ms-auto align-items-center"> 
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @else
            {{-- Admin Home --}}
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link" title="Admin Home">
                    <i class="fa-solid fa-house"></i>
                </a>
            </li>

            {{-- Hotel Analysis --}}
            <li class="nav-item">
                <a href="{{ route('admin.analysis.hotel') }}" class="nav-link" title="Hotel Analysis">
                    <i class="fa-solid fa-chart-line"></i>
                </a>
            </li>

            {{-- Category Index --}}
            <li class="nav-item">
                <a href="{{ route('admin.category.index') }}" class="nav-link" title="Add Category">
                    <i class="fa-solid fa-circle-plus"></i>
                </a>
            </li>

            <li class="nav-item dropdown me-4">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-sm">
                    <div id="user-menu" class="create-menu" style="margin-left: 10px;">
                        <a href="{{ route('home') }}" class="create-item d-flex align-items-center py-2 text-decoration-none text-dark">
                            <i class="fa-solid fa-user-gear me-2 text-primary"></i>User Home
                        </a>
                        
                        <hr class="dropdown-divider">

                        <a href="{{ route('logout') }}" class="create-item d-flex align-items-center py-2 text-decoration-none text-danger"
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
