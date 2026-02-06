@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Hotel</h2>
    <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $hotel->name) }}" required>
        </div>
        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $hotel->city) }}">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $hotel->phone) }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $hotel->address) }}">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.hotels') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

