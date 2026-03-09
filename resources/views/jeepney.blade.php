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

    .jeepney-wrapper {
        max-width: 1100px;
        margin: 30px auto;
    }

    .hero-card {
        background: linear-gradient(135deg, #6FA9DE, #51C9D0);
        border: none;
        border-radius: 24px;
        color: #0f2233;
        box-shadow: 0 18px 40px rgba(70, 120, 160, 0.18);
        overflow: hidden;
    }

    .hero-card .card-body {
        padding: 32px;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .hero-sub {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .search-card,
    .result-card,
    .map-card {
        border: none;
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(20, 40, 60, 0.08);
        background: rgba(255, 255, 255, 0.95);
    }

    .search-card .card-body,
    .result-card .card-body {
        padding: 28px;
    }

    .map-wrap {
        padding: 20px;
    }

    #jeepney-map {
        width: 100%;
        height: 460px;
        border-radius: 18px;
    }

    .form-label {
        font-weight: 700;
        color: #24394b;
        margin-bottom: 8px;
    }

    .form-select {
        border-radius: 14px;
        padding: 12px 14px;
        border: 1px solid #dfe7ee;
        min-height: 48px;
    }

    .btn-search {
        border: none;
        border-radius: 14px;
        padding: 12px 18px;
        font-weight: 700;
        background: linear-gradient(135deg, #6FA9DE, #51C9D0);
        color: #102433;
        box-shadow: 0 10px 20px rgba(81, 201, 208, 0.2);
    }

    .btn-search:hover {
        opacity: 0.95;
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
        border-radius: 18px;
        padding: 18px;
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
        margin-top: 24px;
    }
</style>

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

<div class="container jeepney-wrapper">
    <div class="card hero-card mb-4">
        <div class="card-body">
            <div class="hero-title">POKECEBU | Jeepney Finder</div>
            <p class="hero-sub">
                アヤラセンターや IT Park など、主要な停留所の間をどう移動できるか検索できます。
            </p>
        </div>
    </div>

    <div class="card search-card">
        <div class="card-body">
            <form action="{{ route('jeepney.search') }}" method="POST">
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
                            該当する直通ルートは見つかりませんでした。
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card result-card">
                <div class="card-body">
                    <div class="empty-box">
                        出発地と到着地を選ぶと、利用できるジプニールートがここに表示されます。
                    </div>
                </div>
            </div>
        @endisset
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
