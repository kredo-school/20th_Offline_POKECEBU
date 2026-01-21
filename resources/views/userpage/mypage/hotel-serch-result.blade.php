{{-- resources\views\userpage\mypage\hotel-serch-result.blade.php --}}

@extends('layouts.user')

@section('content')

    <div class="container py-4">
        <!-- Search Bar -->
        <div class="search-bar mb-4">
            <form class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Destination">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="Check-in">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="Check-out">
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option>1 Room</option>
                        <option>2 Rooms</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option>2 Adults</option>
                        <option>1 Adult</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-3">
                <div class="filter-sidebar">
                    <h5><i class="fa-solid fa-filter me-2"></i>Filters</h5>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="wifi">
                        <label class="form-check-label" for="wifi">Free Wi-Fi</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="breakfast">
                        <label class="form-check-label" for="breakfast">Breakfast Included</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="parking">
                        <label class="form-check-label" for="parking">Parking</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="pool">
                        <label class="form-check-label" for="pool">Swimming Pool</label>
                    </div>
                </div>
            </div>

            <!-- Hotel Results -->
            <div class="col-md-9">
                <!-- Hotel Card -->
                <div class="hotel-card row g-0">
                    <div class="col-md-4">
                        <img src="https://ak-d.tripcdn.com/images/1mc1o12000dn2ylpx0267_R_600_600_R5_D.jpg_.webp"
                            alt="Hotel Image" class="hotel-image">
                    </div>
                    <div class="col-md-8 hotel-info">
                        <div class="hotel-title">Ginza Capital Hotel Main</div>
                        <div class="hotel-location"><i class="fa-solid fa-location-dot me-1"></i>Near Tokyo Station
                        </div>
                        <div class="hotel-rating"><i class="fa-solid fa-star me-1"></i>8.7 / 10 - Very Good</div>
                        <div class="hotel-price mt-2">¥11,642 per night</div>
                        <p class="text-muted mt-2">“Great access to subway” · “Convenient location”</p>
                        <a href="#" class="btn btn-book mt-2">
                            <i class="fa-solid fa-calendar-check me-1"></i>Book Now
                        </a>
                    </div>
                </div>

                <!-- Another Hotel Card -->
                <div class="hotel-card row g-0">
                    <div class="col-md-4">
                        <img src="https://ak-d.tripcdn.com/images/1mc1o12000dn2ylpx0267_R_600_600_R5_D.jpg_.webp"
                            alt="Hotel Image" class="hotel-image">
                    </div>
                    <div class="col-md-8 hotel-info">
                        <div class="hotel-title">Shinjuku Grand Hotel</div>
                        <div class="hotel-location"><i class="fa-solid fa-location-dot me-1"></i>Shinjuku Area</div>
                        <div class="hotel-rating"><i class="fa-solid fa-star me-1"></i>9.1 / 10 - Excellent</div>
                        <div class="hotel-price mt-2">¥14,200 per night</div>
                        <p class="text-muted mt-2">“Spacious rooms” · “Friendly staff”</p>
                        <a href="#" class="btn btn-book mt-2">
                            <i class="fa-solid fa-calendar-check me-1"></i>Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


