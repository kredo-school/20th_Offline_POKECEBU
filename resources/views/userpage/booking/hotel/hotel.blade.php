@extends('layouts.app')

@section('content')
    <div class="container my-5 d-flex justify-content-center">
        <div class="w-100 text-center" style="max-width: 900px;">

            <!-- ホテル名 -->
            <h1 class="fw-bold mb-4">{{ $hotel->name }}</h1>

            <!-- ホテル画像 -->
            <div class="mb-5">
                @if ($hotel->images->count())
                    <div class="row g-3 justify-content-center">
                        @foreach ($hotel->images as $image)
                            <div class="col-md-6">
                                <img src="{{ $image->image }}" class="img-fluid rounded-4 shadow-sm">
                            </div>
                        @endforeach
                    </div>
                @else
                    <img src="{{ $hotel->image_path ?? $hotel->image }}" class="img-fluid rounded-4 shadow-sm">
                @endif
            </div>

           

            <!-- ルームタイプ一覧 -->
            <h3 class="mb-4">Available Rooms</h3>

            <div class="row g-4 justify-content-center">
                @foreach ($hotel->roomTypes as $roomType)
                    <div class="col-md-8">
                        <div class="card shadow-lg rounded-4 p-4">
                            <h4 class="card-title mb-3">
                                {{ ucfirst($roomType->roomType->name) }} Room
                            </h4>

                            <p class="mb-3">
                                Total Rooms Available:
                                <strong>{{ $roomType->total_rooms }}</strong>
                            </p>

                            <form method="GET" action="{{ route('mypage.show') }}">
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                                <select name="guests" class="form-select mb-3">
                                    <option value="1">1 Person</option>
                                    <option value="2">2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                </select>

                                <button type="submit" class="btn btn-primary w-100">Book Now</button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
