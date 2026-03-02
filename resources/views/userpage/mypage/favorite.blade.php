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
                            <div class="row justify-center g-2 mb-3">
                                @foreach ($favoriteHotels as $hotel)
                                    <div
                                        class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center card favorite-card hotel mb-3">
                                        <div class="card card-favorite">
                                            <img src="{{ $hotel->image_path ?? asset('images/no-image.png') }}"
                                                alt="{{ $hotel->name }}" class="favorite-image">
                                            <div class="favorite-body">
                                                <a href="{{ route('user.hotels.detail', $hotel->id) }}"
                                                    class="favorite-link">
                                                    <h5 class="card-title">{{ $hotel->name }}</h5>
                                                    <p class="card-city">{{ $hotel->city }}</p>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Restaurants --}}
                            <div class="row justify-center g-2 mb-3">
                                @foreach ($favoriteRestaurants as $restaurant)
                                    <div
                                        class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center card favorite-card restaurant mb-3 ">
                                        <div class="card card-favorite">
                                            <img src="{{ $restaurant->image_path ?? asset('images/no-image.png') }}"
                                                alt="{{ $restaurant->name }}" class="favorite-image">
                                            <div class="favorite-body">
                                                <a href="{{ route('user.restaurants.detail', $restaurant->id) }}"
                                                    class="favorite-link">
                                                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                                                    <p class="card-city">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $restaurant->city }}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                        } else if (type === 'hotel') {
                            card.classList.toggle(
                                'd-none',
                                !card.classList.contains('hotel')
                            );
                        } else if (type === 'restaurant') {
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
                    visibleCards.length === 0 ?
                    'block' :
                    'none';
            }

        });
    </script>
@endsection


<style>
    .favorite-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 3 / 3.8;
        width: 100%;
        height: 100%;
        max-width: 320px;
    }

    .favorite-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .favorite-body {
        flex-grow: 1;
    }

    .card-title {
        font-size: 14px;
    }

    .card-text,
    .rank-card .card-price {
        font-size: 13px;
    }

    .card-city {
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .favorite-link {
        text-decoration: none;
        color: #333;
    }
</style>
