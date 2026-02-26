@extends('layouts.user')

<link rel="stylesheet" href="{{ asset('css/user.css/mypage/favorite.css') }}">


@section('content')
    <div class="container mt-5">
        <div class="row">
            {{-- 左メニュー --}}
            <div class="col-3 d-flex flex-column mb-4">
                <a href="{{ route('mypage') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Profile</a>
                <a href="{{ route('booking') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">My
                    Booking</a>
                <a href="{{ route('favorite') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>
            </div>

            {{-- 右コンテンツ --}}
            <div class="col-9">
                <div class="card mb-4 w-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="btn-group w-100" role="group" aria-label="Favorite Type">
                                <input type="radio" class="btn-check" name="favoriteType" id="all"
                                    autocomplete="off" checked>
                                {{-- All button --}}
                                <label class="btn favorite-item all btn-outline-primary" for="all">All</label>
                                <input type="radio" class="btn-check" name="favoriteType" id="hotel"
                                    autocomplete="off">

                                {{-- Hotels button --}}
                                <label class="btn favorite-item hotel btn-outline-primary" for="hotel">Hotel</label>
                                <input type="radio" class="btn-check" name="favoriteType" id="restaurant"
                                    autocomplete="off">

                                {{-- Restaurants butto --}}
                                <label class="btn favorite-item restaurant btn-outline-primary"
                                    for="restaurant">Restaurant</label>
                            </div>
                        </div>

                        @if ($favoriteHotels->isEmpty() && $favoriteRestaurants->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">You have no favorites yet.</h5>
                            </div>
                        @else

                        {{-- Empty message --}}
                        <div id="empty-message" class="text-center py-5" style="display:none;">
                            <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">You have no favorites yet.</h5>
                        </div>
                            {{-- Hotels --}}
                            @foreach ($favoriteHotels as $hotel)
                                <div class="card mb-3 favorite-card hotel">
                                    <div class="card-body">
                                        <h5>{{ $hotel->name }}</h5>
                                        <p>{{ $hotel->address }}</p>
                                        <a href="{{ route('user.hotels.detail', $hotel->id) }}" class="bnt btn-primary">View Hotel</a>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Restaurants --}}
                            @foreach ($favoriteRestaurants as $restaurant)
                                <div class="card mb-3 favorite-card restaurant">
                                    <div class="card-body">
                                        <h5>{{ $restaurant->name }}</h5>
                                        <p>{{ $restaurant->address }}</p>
                                        <a href="{{ route('user.restaurants.detail', $restaurant->id) }}" class="bnt btn-primary">View Restaurant</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


 <script>
document.addEventListener('DOMContentLoaded', function() {

    const radios = document.querySelectorAll('input[name="favoriteType"]');
    const cards = document.querySelectorAll('.favorite-card');
    const emptyMessage = document.getElementById('empty-message');

    radios.forEach(radio => {
        radio.addEventListener('change', function() {

            let type = this.id;

            cards.forEach(card => {

                if (type === 'all') {
                    card.classList.remove('d-none');
                }
                else if (type === 'hotel') {
                    card.classList.toggle(
                        'd-none',
                        !card.classList.contains('hotel')
                    );
                }
                else if (type === 'restaurant') {
                    card.classList.toggle(
                        'd-none',
                        !card.classList.contains('restaurant')
                    );
                }

            });

            checkEmpty();
        });
    });

    function checkEmpty() {
        const visibleCards =
            document.querySelectorAll('.favorite-card:not(.d-none)');

        emptyMessage.style.display =
            visibleCards.length === 0
                ? 'block'
                : 'none';
    }

});
</script>
@endsection
