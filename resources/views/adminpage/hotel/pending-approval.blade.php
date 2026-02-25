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
            <div class="mb-2"><a href="{{ route('admin.showList', 'hotel') }}">◀︎ List of Hotels</a></div>
            {{-- ホテル詳細（右側） --}}
            <div class="col-lg-9">
                @if (isset($tmpHotel) && $tmpHotel)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">
                                    @if (is_null($tmpHotel->hotel_id))
                                        <span class="badge bg-info-subtle text-info me-1">New</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success me-1">Update</span>
                                    @endif
                                    {{ $tmpHotel->name }}
                                </h2>
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
                                <form method="post" action="{{ route('admin.hotel.reject', $tmpHotel->id) }}">
                                    @csrf
                                    {{-- @method('delete') --}}
                                    <textarea name="reject_reason" placeholder="Reasons for reject"></textarea>
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
