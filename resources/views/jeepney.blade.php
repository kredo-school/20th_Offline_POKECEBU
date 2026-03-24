@extends('layouts.app')

@section('navbar')
    <nav class="navbar navbar-expand-md" style="height:80px;">
        @include('layouts.partials.nav-user')
    </nav>
@endsection

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            background: #f5f6f8;
            font-family: 'Segoe UI', sans-serif;
        }

        .jeepney-page {
            max-width: 1460px;
            margin: 0 auto;
            padding: 20px 24px 60px;
        }

        /* ===== ここは送ってくれたコードをベースにそのまま採用 ===== */
        .top-photo {
            width: 100%;
            max-width: 1200px;
            /* 共通の横幅に制限 */
            height: 200px;
            margin: 0 auto 20px;
            /* 中央寄せ */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            background-image: url("{{ asset('images/jeepney/hero-jeepney.jpg') }}");
            background-color: rgba(0, 0, 0, 0.1);
            background-blend-mode: multiply;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }


        .top-photo h1 {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            margin: 0;
            position: relative;
            z-index: 2;
        }

        /* ===== 検索バー ===== */
        .search-bar {
            display: grid;
            grid-template-columns: 1fr 1fr 180px;
            gap: 10px;
            margin-bottom: 18px;
        }

        .search-bar .form-select {
            height: 56px;
            border-radius: 10px;
            border: 1px solid #d9dde3;
            background: #fff;
            font-size: 1rem;
            box-shadow: none;
        }

        .search-btn {
            height: 56px;
            border: none;
            border-radius: 10px;
            background: #0d6efd;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .search-btn:hover {
            background: #0b5ed7;
        }

        /* ===== メインレイアウト ===== */
        .content-grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 22px;
            align-items: start;
        }

        .side-panel,
        .result-panel,
        .map-panel {
            background: #fff;
            border: 1px solid #d9dde3;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .side-panel {
            padding: 22px 18px;
        }

        .side-title {
            font-size: 1.45rem;
            font-weight: 800;
            margin-bottom: 18px;
            color: #222;
        }

        .side-section-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #222;
        }

        .helper-box {
            background: #f8f9fb;
            border: 1px solid #e4e7ec;
            border-radius: 10px;
            padding: 14px;
            color: #555;
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 16px;
        }

        .info-chip {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: #eef4ff;
            color: #0d6efd;
            font-weight: 700;
            font-size: 0.9rem;
            margin: 4px 6px 0 0;
        }

        .result-panel {
            padding: 0;
            overflow: hidden;
        }

        .result-header {
            padding: 18px 22px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .result-header h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
            color: #222;
        }

        .trip-badge {
            background: #f0f6ff;
            color: #0d6efd;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .route-card {
            display: grid;
            grid-template-columns: 170px 1fr 170px;
            /* 左右を同じ幅に */
            gap: 20px;
            padding: 20px 22px;
            border-bottom: 1px solid #e9ecef;
            align-items: stretch;
        }

        .route-image {
            width: 100%;
            height: 150px;
            /* 右の写真と同じ高さに */
            border-radius: 10px;
            object-fit: cover;
            background: #f1f3f5;
        }


        .route-card:last-child {
            border-bottom: none;
        }



        .route-main {
            min-width: 0;
        }

        .route-code {
            display: inline-block;
            margin-bottom: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #eaf3ff;
            color: #0d6efd;
            font-weight: 800;
            font-size: 0.95rem;
        }

        .route-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: #222;
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .route-meta {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .route-stops {
            color: #555;
            line-height: 1.8;
            font-size: 0.96rem;
        }

        .route-side {
            text-align: right;
        }

        .fare-label {
            display: inline-block;
            background: #f5f7fa;
            color: #666;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .fare-price {
            font-size: 2rem;
            font-weight: 800;
            color: #222;
            line-height: 1;
            margin-bottom: 4px;
        }

        .fare-sub {
            color: #666;
            font-size: 0.92rem;
            margin-bottom: 14px;
        }

        .empty-box {
            padding: 22px;
            color: #666;
            background: #fff;
        }

        .map-panel {
            margin-top: 22px;
            padding: 18px;
        }

        .route-map {
            width: 100%;
            height: 150px;
            border-radius: 10px;
            background: #f1f3f5;
        }

        .map-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 14px;
            color: #222;
        }

        #jeepney-map {
            width: 100%;
            height: 460px;
            border-radius: 10px;
        }

        .transfernozi{
            font-size: 1.25rem;
            font-weight: 800;
            margin-top: 10px;
            padding: 20px;
        }

        @media (max-width: 1100px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .route-card {
                grid-template-columns: 1fr;
            }

            .route-side {
                text-align: left;
            }
        }

        /* スマホ用に高さを少し縮める */
        @media (max-width: 768px) {
            .top-photo {
                height: 180px;
            }

            .top-photo h1 {
                font-size: 2.1em;
                padding: 0 16px;
            }
        }
    </style>

    @php
        $mapRoutes = isset($routes)
            ? $routes
                ->map(function ($route) {
                    return [
                        'id' => $route->id,
                        'code' => $route->code,
                        'name' => $route->name,
                        'fare' => $route->fare,
                        'notes' => $route->notes,
                        'stops' => $route->stops
                            ->map(function ($stop) {
                                return [
                                    'id' => $stop->id,
                                    'name' => $stop->name,
                                    'lat' => $stop->lat !== null ? (float) $stop->lat : null,
                                    'lng' => $stop->lng !== null ? (float) $stop->lng : null,
                                    'stop_order' => $stop->pivot->stop_order ?? null,
                                ];
                            })
                            ->values()
                            ->toArray(),
                    ];
                })
                ->values()
                ->toArray()
            : [];

        $mapFromStop = isset($fromStop)
            ? [
                'id' => $fromStop->id,
                'name' => $fromStop->name,
                'lat' => $fromStop->lat !== null ? (float) $fromStop->lat : null,
                'lng' => $fromStop->lng !== null ? (float) $fromStop->lng : null,
            ]
            : null;

        $mapToStop = isset($toStop)
            ? [
                'id' => $toStop->id,
                'name' => $toStop->name,
                'lat' => $toStop->lat !== null ? (float) $toStop->lat : null,
                'lng' => $toStop->lng !== null ? (float) $toStop->lng : null,
            ]
            : null;
    @endphp

    <div class="jeepney-page">

        <div class="top-photo">
            <h1>Find Your Jeepney Route</h1>
        </div>

        <form action="{{ route('user.jeepney.search') }}" method="POST" class="search-bar">
            @csrf

            <select name="from_stop_id" id="from_stop_id" class="form-select" required>
                <option value="">Departure</option>
                @foreach ($stops ?? [] as $stop)
                    <option value="{{ $stop->id }}"
                        {{ old('from_stop_id', $fromStop->id ?? '') == $stop->id ? 'selected' : '' }}>
                        {{ $stop->name }}
                    </option>
                @endforeach
            </select>

            <select name="to_stop_id" id="to_stop_id" class="form-select" required>
                <option value="">Destination</option>
                @foreach ($stops ?? [] as $stop)
                    <option value="{{ $stop->id }}"
                        {{ old('to_stop_id', $toStop->id ?? '') == $stop->id ? 'selected' : '' }}>
                        {{ $stop->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="search-btn">Search</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="content-grid">
            <div class="side-panel">
                <div class="side-title">Jeepney Guide</div>

                <div class="side-section-title">Popular Stops</div>
                <div class="helper-box">
                    Choose major Cebu spots such as Ayala Center Cebu, IT Park, Colon, or SM City to quickly find a route.
                </div>

                <div class="side-section-title">Quick Info</div>
                <div>
                    <span class="info-chip">Stops: {{ isset($stops) ? $stops->count() : 0 }}</span>
                    <span class="info-chip">Routes: {{ isset($routes) ? $routes->count() : 0 }}</span>
                    <span class="info-chip">Cebu City</span>
                </div>
            </div>

            <div>
                <div class="result-panel">
                    <div class="result-header">
                        <h2>Jeepney Results</h2>

                        @isset($fromStop)
                            @isset($toStop)
                                <span class="trip-badge">{{ $fromStop->name }} → {{ $toStop->name }}</span>
                            @endisset
                        @endisset
                    </div>

                    @isset($fromStop)
                        @isset($toStop)
                            {{-- 直接ルート --}}
                            @if (isset($routes) && $routes->count())
                                @foreach ($routes as $route)
                                    <div class="route-card">
                                        {{-- 左側に地図を表示 --}}
                                        <div class="route-map" id="map-route-{{ $route->id }}"></div>

                                        <div class="route-main">
                                            <div class="route-code">{{ $route->code }}</div>
                                            <div class="route-name">{{ $route->name }}</div>

                                            @if ($route->notes)
                                                <div class="route-meta">{{ $route->notes }}</div>
                                            @else
                                                <div class="route-meta">Direct jeepney route through major city stops.</div>
                                            @endif

                                            <div class="route-stops">
                                                @foreach ($route->stops as $stop)
                                                    • {{ $stop->name }}<br>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="route-side">
                                            <div class="fare-label">Estimated Fare</div>
                                            <div class="fare-price">{{ $route->fare ?? '₱13.00' }}</div>
                                            <div class="fare-sub">per ride</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-box">
                                    Sorry, no direct route could be found.
                                </div>
                            @endif

                            {{-- 乗り換えルート --}}
                            @if (!empty($transferOptions))
                                <div class="transfernozi"><h3>Transfer Routes</h3></div>
                                @foreach ($transferOptions as $option)
                                    <div class="route-card">
                                        {{-- 左側に地図を表示 --}}
                                        <div class="route-map"
                                            id="map-transfer-{{ $option['firstRoute']->id }}-{{ $option['secondRoute']->id }}">
                                        </div>

                                        <div class="route-main">
                                            <div class="route-code">
                                                {{ $option['firstRoute']->code }} → {{ $option['secondRoute']->code }}
                                            </div>
                                            <div class="route-name">
                                                Transfer at {{ $option['transferStop']->name }}
                                            </div>
                                            <div class="route-meta">
                                                {{ $fromStop->name }} → {{ $option['firstRoute']->name }} →
                                                {{ $option['transferStop']->name }} (Transfer) → {{ $option['secondRoute']->name }} →
                                                {{ $toStop->name }}
                                            </div>
                                        </div>

                                        <div class="route-side">
                                            <div class="fare-label">Estimated Fare</div>
                                            <div class="fare-price">
                                                {{ $option['firstRoute']->fare ?? '₱13.00' }} +
                                                {{ $option['secondRoute']->fare ?? '₱13.00' }}
                                            </div>
                                            <div class="fare-sub">per ride (2 rides)</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <div class="empty-box">
                                Please select your departure and destination to view available jeepney routes.
                            </div>
                        @endisset
                    @endisset
                </div>

                <div class="map-panel">
                    <div class="map-title">Route Map</div>
                    <div id="jeepney-map"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                map.fitBounds(bounds, {
                    padding: [40, 40]
                });
            }
        });
    </script>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 直接ルート用
    @if(isset($routes) && $routes->count())
        @foreach ($routes as $route)
            var mapRoute{{ $route->id }} = L.map('map-route-{{ $route->id }}').setView([10.315, 123.885], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mapRoute{{ $route->id }});

            var stopsRoute{{ $route->id }} = [
                @foreach ($route->stops as $stop)
                    {lat: {{ $stop->lat }}, lng: {{ $stop->lng }}, name: "{{ $stop->name }}"},
                @endforeach
            ];

            var latlngsRoute{{ $route->id }} = stopsRoute{{ $route->id }}.map(s => [s.lat, s.lng]);
            L.polyline(latlngsRoute{{ $route->id }}, {color: 'blue'}).addTo(mapRoute{{ $route->id }});

            stopsRoute{{ $route->id }}.forEach(s => {
                L.marker([s.lat, s.lng]).addTo(mapRoute{{ $route->id }}).bindPopup(s.name);
            });

            mapRoute{{ $route->id }}.fitBounds(latlngsRoute{{ $route->id }});
        @endforeach
    @endif

    // 乗り換えルート用
    @if(!empty($transferOptions))
        @foreach ($transferOptions as $option)
            var mapTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }} =
                L.map('map-transfer-{{ $option['firstRoute']->id }}-{{ $option['secondRoute']->id }}').setView([10.315, 123.885], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mapTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }});

            // ここでは firstRoute の停留所を例に描画
            var stopsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }} = [
                @foreach ($option['firstRoute']->stops as $stop)
                    {lat: {{ $stop->lat }}, lng: {{ $stop->lng }}, name: "{{ $stop->name }}"},
                @endforeach
            ];

            var latlngsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }} =
                stopsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }}.map(s => [s.lat, s.lng]);

            L.polyline(latlngsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }}, {color: 'green'})
                .addTo(mapTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }});

            stopsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }}.forEach(s => {
                L.marker([s.lat, s.lng]).addTo(mapTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }}).bindPopup(s.name);
            });

            mapTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }}.fitBounds(latlngsTransfer{{ $option['firstRoute']->id }}{{ $option['secondRoute']->id }});
        @endforeach
    @endif
});
</script>
@endpush

