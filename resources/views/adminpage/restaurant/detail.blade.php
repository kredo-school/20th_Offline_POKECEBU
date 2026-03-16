@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="mb-2"><a href="{{ route('admin.showList', 'restaurant') }}">◀︎ List of Restaurants</a></div>
            {{-- ホテル詳細（右側） --}}
            <div class="col-lg-9">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">{{ $restaurant->name }}</h2>
                            <div class="text-warning fs-5">
                                @for ($i = 0; $i < floor($restaurant->star_rating ?? 0); $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                @if (isset($restaurant->star_rating) && $restaurant->star_rating - floor($restaurant->star_rating) >= 0.5)
                                    <i class="fa-regular fa-star-half-stroke"></i>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="mt-2"><i class="fa-solid fa-location-dot me-1"></i> {{ $restaurant->city ?? '—' }}</p>

                    <div class="row mb-3">
                        @if ($restaurant->images && $restaurant->images->isNotEmpty())
                            @foreach ($restaurant->images as $img)
                                <div class="col-md-6">
                                    <img src="{{ $img->image }}" class="img-fluid rounded mb-2"
                                        alt="Restaurant Image">
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-muted">No images uploaded.</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        {{-- ここにタグやバッジがあれば表示 --}}
                        {{-- 例: カテゴリや設備があればループで表示 --}}
                    </div>

                    <h4 class="mt-3"><i class="fa-solid fa-circle-info me-2"></i>Restaurant Details</h4>
                    <p>{{ $restaurant->description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection