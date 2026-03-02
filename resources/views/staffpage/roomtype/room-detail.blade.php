@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="mb-2"><a href="{{ route('hotel.overview', Auth::user()->id) }}">◀︎ Room overview</a></div>

        <div class="col-md-10 p-4">
            <div class="bg-light"><h2 class="mb-1">View Details</h2></div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="room_num" class="form-label">Room Number</label>
                    <input type="text" name="room_num" id="room_num" class="form-control" value="{{ $room->room_number }}" readonly>
                </div>

                <div class="col-md-6 mb-2">
                    <label for="type_id" class="form-label">Room Type</label>
                    <input type="text" name="type_id" id="type_id" class="form-control" value="{{ $room->type->name }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="floor_num" class="form-label">Floor Number</label>
                    <input type="number" name="floor_num" id="floor_num" class="form-control" value="{{ $room->floor_number }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="guests" class="form-label">Max Guests</label>
                    <input type="number" name="guests" id="guests" class="form-control" value="{{ $room->max_guests }}" readonly>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="charges" class="form-label">Charges</label>
                    <div class="input-group">
                        <div class="input-group-text bg-light">₱</div>
                        <input type="number" name="charges" id="charges" class="form-control" value="{{ $room->charges }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="guests" class="form-label">Status</label>
                    <input type="text" name="type_id" id="type_id" class="form-control" value="{{ $room->status->name }}" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Amenities</label>
                <div class="category-box">
                    @if ($room->categories->isEmpty())
                        <span class="text-muted small ms-3">No amenity</span>
                    @else
                        @foreach ($room->categories as $category)
                            <span class="badge border bg-light text-dark me-1 mb-1">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="detail" class="form-label">Description of this room</label>
                <textarea name="detail" id="detail" class="form-control" rows="10">{{ $room->detail }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Existing Images</label>
                <div class="d-flex flex-wrap gap-2">
                    @if ($room->images->isEmpty())
                        <span class="text-muted small ms-3">No image</span>
                    @else
                        @foreach ($room->images as $image)
                            <div class="position-relative existing-image" data-id="{{ $image->id }}" style="display:inline-block;">
                                <img src="{{ $image->image }}" alt="Room Image"
                                     style="width:100px; height:auto; border:1px solid #ccc; border-radius:4px;">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

