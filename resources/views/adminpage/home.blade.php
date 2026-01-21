@extends('layouts.admin')

@section('title', 'Admin Home')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 mb-5">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><a href="" class="text-decoration-none text-dark">{{ number_format($totalUsers) }}</a></h3>
                        <p>all users</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-5">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><a href="" class="text-decoration-none text-dark">{{ number_format($pageViews) }}</a></h3>
                        <p>page views</p>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4>Pending approval</h4>
                    </div>

                    <div class="card-body">

                        {{-- pendingようのテーブル作って@foreachのところのコメントを外す --}}

                        {{-- Hotels --}}
                        {{-- @foreach ($pendingHotels as $hotel) --}}
                            <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                                <div>
                                    {{-- ここもdbから持ってくる --}}
                                    <a href="#" class="text-decoration-none text-dark">🏨 Hotel name</a>
                                </div>
                                <span class="badge bg-warning text-dark">
                                    ✔ Pending
                                </span>
                            </div>
                        {{-- @endforeach --}}

                        {{-- Restaurants --}}
                        {{-- @foreach ($pendingRestaurants as $restaurant) --}}
                            <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                                <div>
                                    {{-- ここもdbから持ってくる --}}
                                    <a href="#" class="text-decoration-none text-dark">🍴 Restaurant name</a>
                                </div>
                                <span class="badge bg-warning text-dark">
                                    ✔ Pending
                                </span>
                            </div>
                        {{-- @endforeach --}}

                        {{-- @if ($pendingHotels->isEmpty() && $pendingRestaurants->isEmpty()) --}}
                            <p class="text-muted">No pending approvals 🎉</p>
                        {{-- @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
