@extends('layouts.app')

@section('content')
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    body {
        background: linear-gradient(180deg, #fffef7 0%, #fff8ee 100%);
    }

    .jeepney-page {
        background: linear-gradient(180deg, #fffef7 0%, #fff8ee 100%);
        min-height: 100vh;
        padding-bottom: 60px;
    }

    .jeepney-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ===== Hero ===== */
    .jeepney-hero {
        position: relative;
        min-height: 540px;
        border-radius: 0 0 38px 38px;
        overflow: hidden;
        margin-bottom: 80px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
    }

    .jeepney-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(11, 33, 44, 0.68) 0%, rgba(11, 33, 44, 0.32) 38%, rgba(11, 33, 44, 0.08) 100%);
    }

    .jeepney-hero-inner {
        position: relative;
        z-index: 2;
        padding: 90px 70px 120px;
        color: #fff;
        max-width: 760px;
    }

    .jeepney-kicker {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(6px);
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .jeepney-hero-title {
        font-size: clamp(2.5rem, 5vw, 4.8rem);
        line-height: 1.08;
        font-weight: 900;
        letter-spacing: 0.5px;
        margin-bottom: 18px;
        text-transform: uppercase;
    }

    .jeepney-hero-sub {
        font-size: 1.1rem;
        line-height: 1.8;
        max-width: 560px;
        color: rgba(255,255,255,0.92);
        margin-bottom: 0;
    }

    /* wave */
    .jeepney-hero-wave {
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 100%;
        height: 170px;
        z-index: 2;
        pointer-events: none;
    }

    .jeepney-hero-wave svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* floating info bubbles */
    .hero-bubbles {
        position: absolute;
        right: 80px;
        bottom: 24px;
        z-index: 3;
        display: flex;
        gap: 22px;
        align-items: flex-end;
        flex-wrap: wrap;
        justify-content: flex-end;
        max-width: 560px;
    }

    .bubble-card {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 999px;
        box-shadow: 0 16px 28px rgba(0, 0, 0, 0.10);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #22394b;
        text-align: center;
    }

    .bubble-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #7c8a97;
        margin-bottom: 6px;
    }

    .bubble-value {
        font-size: 1.2rem;
        font-weight: 800;
    }

    /* ===== Cards ===== */
    .search-card,
    .result-card,
    .map-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 14px 32px rgba(20, 40, 60, 0.08);
        background: rgba(255, 255, 255, 0.97);
    }

    .search-card {
        margin-top: -30px;
        position: relative;
        z-index: 5;
    }

    .search-card .card-body,
    .result-card .card-body {
        padding: 30px;
    }

    .map-wrap {
        padding: 20px;
    }

    #jeepney-map {
        width: 100%;
        height: 500px;
        border-radius: 22px;
    }

    .section-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #163042;
        margin-bottom: 18px;
    }

    .form-label {
        font-weight: 700;
        color: #24394b;
        margin-bottom: 8px;
    }

    .form-select {
        border-radius: 16px;
        padding: 12px 14px;
        border: 1px solid #dfe7ee;
        min-height: 50px;
    }

    .btn-search {
        border: none;
        border-radius: 16px;
        padding: 12px 18px;
        font-weight: 800;
        background: linear-gradient(135deg, #6FA9DE, #51C9D0);
        color: #102433;
        box-shadow: 0 10px 20px rgba(81, 201, 208, 0.2);
    }

    .btn-search:hover {
        opacity: 0.96;
        transform: translateY(-1px);
    }

    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 18px;
    }

    .result-title {
        font-size: 1.25rem;
        font-weight: 800;
        margin: 0;
        color: #102433;
    }

    .trip-badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        background: #eef9fb;
        color: #15435a;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .route-box {
        border: 1px solid #ece7da;
        border-radius: 20px;
        padding: 20px;
        background: #fff;
        height: 100%;
        transition: 0.2s ease;
    }

    .route-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06);
    }

    .route-code {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 12px;
        background: linear-gradient(135deg, #B7E1DA, #96CCB9);
        font-weight: 800;
        color: #10333a;
        min-width: 68px;
        text-align: center;
        margin-bottom: 12px;
    }

    .route-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1e3447;
        margin-bottom: 8px;
    }

    .route-meta {
        color: #5d7181;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .fare-tag {
        display: inline-block;
        background: #fff4df;
        color: #875600;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .stops-list {
        margin: 0;
        padding-left: 18px;
        color: #344b5b;
    }

    .empty-box {
        background: #fffdf8;
        border: 1px dashed #e4dccc;
        border-radius: 18px;
        padding: 20px;
        color: #6b7a88;
    }

    .section-space {
        margin-top: 28px;
    }

    @media (max-width: 991px) {
        .jeepney-hero {
            min-height: 560px;
        }

        .jeepney-hero-inner {
            padding: 70px 28px 150px;
        }

        .hero-bubbles {
            left: 20px;
            right: 20px;
            justify-content: center;
            bottom: 24px;
        }

        .bubble-card {
            width: 100px;
            height: 100px;
        }
    }

    @media (max-width: 576px) {
        .jeepney-hero-title {
            font-size: 2.2rem;
        }

        .jeepney-hero-sub {
            font-size: 0.95rem;
        }

        .search-card .card-body,
        .result-card .card-body {
            padding: 20px;
        }

        #jeepney-map {
            height: 380px;
        }
    }
</style>

@php
    $heroImage = asset('images/jeepney/hero-jeepney.jpg');
@endphp

@php
    $mapRoutes = isset($routes)
        ? $routes->map(function ($route) {
            return [
                'id' => $route->id,
                'code' => $route->code,
                'name' => $route->name,
                'stops' => $route->stops->map(function ($stop) {
                    return [
                        'id' => $stop->id,
                        'name' => $stop->name,
                        'lat' => $stop->lat !== null ? (float) $stop->lat : null,
                        'lng' => $stop->lng !== null ? (float) $stop->lng : null,
                        'stop_order' => $stop->pivot->stop_order ?? null,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray()
        : [];

    $mapFromStop = isset($fromStop) ? [
        'id' => $fromStop->id,
        'name' => $fromStop->name,
        'lat' => $fromStop->lat !== null ? (float) $fromStop->lat : null,
        'lng' => $fromStop->lng !== null ? (float) $fromStop->lng : null,
    ] : null;

    $mapToStop = isset($toStop) ? [
        'id' => $toStop->id,
        'name' => $toStop->name,
        'lat' => $toStop->lat !== null ? (float) $toStop->lat : null,
        'lng' => $toStop->lng !== null ? (float) $toStop->lng : null,
    ] : null;
@endphp

<div class="jeepney-page">
    <div class="jeepney-wrapper">
        <section class="jeepney-hero" style="background-image: url('{{ $heroImage }}');">
            <div class="jeepney-hero-inner">
                <span class="jeepney-kicker">POKECEBU JEEPNEY GUIDE</span>
                <h1 class="jeepney-hero-title">
                    FIND THE RIGHT<br>
                    JEEPNEY<br>
                    FOR YOUR TRIP
                </h1>
                <p class="jeepney-hero-sub">
                    Search popular destinations like Ayala Center Cebu, IT Park, Colon, and more.
                    Find which jeepney route to take in a simple and visual way.
                </p>
            </div>

            <div class="hero-bubbles">
                <div class="bubble-card">
                    <div class="bubble-label">Route</div>
                    <div class="bubble-value">{{ isset($routes) ? $routes->count() : 0 }}</div>
                </div>
                <div class="bubble-card">
                    <div class="bubble-label">Stops</div>
                    <div class="bubble-value">{{ isset($stops) ? $stops->count() : 0 }}</div>
                </div>
                <div class="bubble-card">
                    <div class="bubble-label">Easy</div>
                    <div class="bubble-value">Guide</div>
                </div>
                <div class="bubble-card">
                    <div class="bubble-label">Travel</div>
                    <div class="bubble-value">Cebu</div>
                </div>
            </div>

            <div class="jeepney-hero-wave">
                <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path fill="#fffef7" fill-opacity="1"
                        d="M0,224L48,245.3C96,267,192,309,288,309.3C384,309,480,267,576,234.7C672,203,768,181,864,149.3C960,117,1056,75,1152,64C1248,53,1344,75,1392,85.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </section>

        <div class="card search-card">
            <div class="card-body">
                <div class="section-title">Search Jeepney Route</div>

                <form action="{{ route('user.jeepney.search') }}" method="POST">
                    @csrf

                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="from_stop_id" class="form-label">From</label>
                            <select name="from_stop_id" id="from_stop_id" class="form-select" required>
                                <option value="">Select departure</option>
                                @foreach(($stops ?? []) as $stop)
                                    <option value="{{ $stop->id }}"
                                        {{ old('from_stop_id', $fromStop->id ?? '') == $stop->id ? 'selected' : '' }}>
                                        {{ $stop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label for="to_stop_id" class="form-label">To</label>
                            <select name="to_stop_id" id="to_stop_id" class="form-select" required>
                                <option value="">Select destination</option>
                                @foreach(($stops ?? []) as $stop)
                                    <option value="{{ $stop->id }}"
                                        {{ old('to_stop_id', $toStop->id ?? '') == $stop->id ? 'selected' : '' }}>
                                        {{ $stop->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-search w-100">Search</button>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-0">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="section-space">
            <div class="card map-card">
                <div class="map-wrap">
                    <div id="jeepney-map"></div>
                </div>
            </div>
        </div>

        <div class="section-space">
            @isset($fromStop, $toStop)
                <div class="card result-card">
                    <div class="card-body">
                        <div class="result-header">
                            <h2 class="result-title">Search Results</h2>
                            <span class="trip-badge">{{ $fromStop->name }} → {{ $toStop->name }}</span>
                        </div>

                        @if(isset($routes) && $routes->count())
                            <div class="row g-3">
                                @foreach($routes as $route)
                                    <div class="col-md-6">
                                        <div class="route-box">
                                            <div class="route-code">{{ $route->code }}</div>
                                            <div class="route-name">{{ $route->name }}</div>

                                            @if($route->fare)
                                                <div class="fare-tag">Fare: {{ $route->fare }}</div>
                                            @endif

                                            @if($route->notes)
                                                <div class="route-meta">{{ $route->notes }}</div>
                                            @endif

                                            <div class="fw-bold mb-2">Stops</div>
                                            <ol class="stops-list">
                                                @foreach($route->stops as $stop)
                                                    <li>{{ $stop->name }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-box">
                                Sorry, no direct route could be found.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card result-card">
                    <div class="card-body">
                        <div class="empty-box">
                            Choose your starting point and destination to see the jeepney routes available.
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('jeepney-map');
    if (!mapElement) return;

    const map = L.map('jeepney-map').setView([10.3155, 123.9050], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const routes = @json($mapRoutes);
    const fromStop = @json($mapFromStop);
    const toStop = @json($mapToStop);

    const bounds = [];
    const routeColors = ['#2E86DE', '#E67E22', '#27AE60', '#8E44AD', '#D35400', '#16A085'];

    if (routes.length > 0) {
        routes.forEach((route, index) => {
            const color = routeColors[index % routeColors.length];

            const sortedStops = [...route.stops].sort((a, b) => {
                return (a.stop_order ?? 9999) - (b.stop_order ?? 9999);
            });

            const latlngs = sortedStops
                .filter(stop => stop.lat !== null && stop.lng !== null)
                .map(stop => [stop.lat, stop.lng]);

            if (latlngs.length > 1) {
                const polyline = L.polyline(latlngs, {
                    color: color,
                    weight: 6,
                    opacity: 0.85
                }).addTo(map);

                polyline.bindPopup(`<strong>${route.code}</strong><br>${route.name}`);

                latlngs.forEach(latlng => bounds.push(latlng));
            }

            sortedStops.forEach(stop => {
                if (stop.lat !== null && stop.lng !== null) {
                    const marker = L.circleMarker([stop.lat, stop.lng], {
                        radius: 6,
                        color: color,
                        fillColor: color,
                        fillOpacity: 0.9,
                        weight: 2
                    }).addTo(map);

                    marker.bindPopup(
                        `<strong>${stop.name}</strong><br>Route: ${route.code}<br>Order: ${stop.stop_order ?? '-'}`
                    );

                    bounds.push([stop.lat, stop.lng]);
                }
            });
        });
    }

    if (fromStop && fromStop.lat !== null && fromStop.lng !== null) {
        const fromMarker = L.marker([fromStop.lat, fromStop.lng]).addTo(map);
        fromMarker.bindPopup(`<strong>From</strong><br>${fromStop.name}`);
        bounds.push([fromStop.lat, fromStop.lng]);
    }

    if (toStop && toStop.lat !== null && toStop.lng !== null) {
        const toMarker = L.marker([toStop.lat, toStop.lng]).addTo(map);
        toMarker.bindPopup(`<strong>To</strong><br>${toStop.name}`);
        bounds.push([toStop.lat, toStop.lng]);
    }

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40] });
    }
});
</script>
@endsection

@section('navbar')
<nav class="navbar navbar-expand-md" style="height:80px;">
    @include('layouts.partials.nav-user')
</nav>
@endsection
