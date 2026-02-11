@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- フラッシュメッセージ表示（追加） --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="row">
            {{-- ホテル一覧（左側） --}}
            <div class="col-lg-3 mb-4">
                <h4 class="mb-3"><i class="fa-solid fa-building me-2"></i>Pending Hotels</h4>
                <ul class="list-group">
                    @forelse($tmpHotels as $hotel)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $hotel->name }}
                            <a href="{{ route('admin.hotel.approval.show', $hotel->id) }}"
                                class="btn btn-sm btn-outline-primary">Review</a>
                        </li>
                    @empty
                        <li class="list-group-item">No pending hotels</li>
                    @endforelse
                </ul>
            </div>

            {{-- ホテル詳細（右側） --}}
            <div class="col-lg-9">
                @if (isset($tmpHotel) && $tmpHotel)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">{{ $tmpHotel->name }}</h2>
                                <div class="text-warning fs-5">
                                    @for ($i = 0; $i < floor($tmpHotel->star_rating ?? 0); $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @if (isset($tmpHotel->star_rating) && $tmpHotel->star_rating - floor($tmpHotel->star_rating) >= 0.5)
                                        <i class="fa-regular fa-star-half-stroke"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <form method="post" action="{{ route('admin.hotel.approve', $tmpHotel->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form method="post" action="{{ route('admin.hotel.reject', $tmpHotel->id) }}" >
                                    @csrf
                                    {{-- @method('delete') --}}
                                    <button type="submit" class="btn btn-danger btn-lg rounded-pill">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="mt-2"><i class="fa-solid fa-location-dot me-1"></i> {{ $tmpHotel->city ?? '—' }}</p>

                        <div class="row mb-3">
                            @if ($tmpHotel->images && $tmpHotel->images->isNotEmpty())
                                @foreach ($tmpHotel->images as $img)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/' . $img->image) }}" class="img-fluid rounded mb-2"
                                            alt="Hotel Image">
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

                        <h4 class="mt-3"><i class="fa-solid fa-circle-info me-2"></i>Hotel Details</h4>
                        <p>{{ $tmpHotel->description ?? 'No description provided.' }}</p>
                    </div>
                @else
                    <p>No hotel selected.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
