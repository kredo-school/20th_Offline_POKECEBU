<div class="container-fluid">
    <a class="navbar-brand" href="/admin"
        style="display: flex; align-items: center; height: 70px; overflow: hidden; vertical-align: middle;">
        <img src="{{ asset('images/Icon.png') }}"
            style="height: 180px; margin-top: -5px; margin-bottom: -5px; width: auto; object-fit: contain;">
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
                <a class="nav-link dropdown-toggle fw-bold text-dark px-3" data-bs-toggle="dropdown" href="#"
                    role="button" aria-expanded="false"></i> {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2" style="min-width: 200px;">

                    <div class="px-3 py-2">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Account Settings</small>
                    </div>

                    <a href="{{ route('home') }}" class="dropdown-item d-flex align-items-center py-2 rounded-2 text-dark">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="fw-semibold">User Home</span>
                    </a>

                    <hr class="dropdown-divider my-2">

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
