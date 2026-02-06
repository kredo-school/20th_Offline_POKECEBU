@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">Reservation Confirmation</h2>

    {{-- エラーや警告表示 --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(!$hotel || !$roomType)
        <div class="alert alert-warning">ホテル情報またはルーム情報が見つかりません。</div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
    @else

    <!-- ホテル情報 -->
    <div class="card rounded-4 shadow-sm p-4 mb-4">
        <h4 class="mb-3">Hotel Information</h4>
        <p><strong>Name:</strong> {{ $hotel->name }}</p>

        <!-- 画像 -->
        <div class="mb-3">
            @if ($hotel->images && $hotel->images->count())
                <div class="row g-3">
                    @foreach ($hotel->images as $image)
                        <div class="col-md-6 mb-2">
                            <img src="{{ $image->image }}" class="img-fluid rounded-3 shadow-sm">
                        </div>
                    @endforeach
                </div>
            @else
                <img src="{{ $hotel->image_path ?? $hotel->image }}" class="img-fluid rounded-3 shadow-sm">
            @endif
        </div>

    <div class="card rounded-4 shadow-sm p-4 mb-4">
    <h4 class="mb-3">Price Details</h4>
    <p>Price per night: <strong>¥{{ number_format($price) }}</strong></p>
    <p>Total: <span class="fs-4 text-primary">¥{{ number_format($price * $guestsCount) }}</span></p>
</div>

<form method="POST" action="{{ route('reservation.payment.form') }}">
    @csrf
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
    <input type="hidden" name="guests" value="{{ $guestsCount }}">
    
 
</form>
    </div>

    <!-- ルーム情報 -->
    <div class="card rounded-4 shadow-sm p-4 mb-4">
        <h4 class="mb-3">Room Information</h4>
        <p><strong>Room:</strong> {{ $roomType->roomType->name ?? 'N/A' }}</p>
        <p><strong>Number of Guests:</strong> {{ $guestsCount }}</p>
    </div>

    <!-- メインゲスト情報 -->
<div class="card rounded-4 shadow-sm p-4 mb-4">
    <h4 class="mb-3">Main Guest</h4>
    {{-- $userDetail がオブジェクトなので -> 形式でアクセス --}}
    <p><strong>Name:</strong> {{ $userDetail->first_name ?? '' }} {{ $userDetail->last_name ?? '' }}</p>
    <p><strong>Phone:</strong> {{ $userDetail->phone ?? '' }}</p>
    <p><strong>Address:</strong> 
        {{ $userDetail->street_address ?? '' }}, 
        {{ $userDetail->city ?? '' }}, 
        {{ $userDetail->state ?? '' }} 
        {{ $userDetail->postal_code ?? '' }}
    </p>
</div>

    <!-- 追加ゲスト情報 -->
  @if(!empty($otherGuests))
<div class="card rounded-4 shadow-sm p-4 mb-4">
    <h4 class="mb-3">Additional Guests</h4>
    @foreach($otherGuests as $guest)
        <p><strong>Name:</strong> {{ $guest['name'] ?? '' }}</p>
        <p><strong>Email:</strong> {{ $guest['email'] ?? '' }}</p>
        <p><strong>Phone:</strong> {{ $guest['phone'] ?? '' }}</p>
        <hr>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('reservation.payment.form') }}">
    @csrf
    {{-- ホテルとルームの基本情報 --}}
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
    <input type="hidden" name="guests" value="{{ $guestsCount }}">

    {{-- メインゲストの情報を payment 画面で表示するために追加 --}}
    <input type="hidden" name="name" value="{{ $userDetail->first_name ?? '' }} {{ $userDetail->last_name ?? '' }}">
    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
    <input type="hidden" name="phone" value="{{ $userDetail->phone ?? '' }}">

    <div class="d-flex gap-2">
        <a href="{{ route('mypage.show') }}" class="btn btn-outline-secondary btn-lg w-25">Back</a>
        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
            Proceed to Payment
        </button>
    </div>
</form>

@endif
</div>
@endsection
