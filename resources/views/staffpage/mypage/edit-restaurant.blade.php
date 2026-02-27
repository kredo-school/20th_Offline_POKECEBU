@extends('layouts.staff')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/mypage/mypage-restaurant.css') }}">
@endpush



@section('content')
<div class="container mt-5">
    <h2>Edit Restaurant Information (Application)</h2>

    <form action="{{ route('staff.update.restaurant') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $restaurant->name) }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $restaurant->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $restaurant->phone) }}">
        </div>

        <div class="mb-3">
            <label>Website</label>
            <input type="text" name="website" class="form-control"
                   value="{{ old('website', $restaurant->website) }}">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control"
                   value="{{ old('address', $restaurant->address) }}">
        </div>

        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control"
                   value="{{ old('city', $restaurant->city) }}">
        </div>

        <div class="mb-3">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control"
                   value="{{ old('latitude', $restaurant->latitude) }}">
        </div>

        <div class="mb-3">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control"
                   value="{{ old('longitude', $restaurant->longitude) }}">
        </div>



        <div class="mb-3">
            <label>Representative Name</label>
            <input type="text" name="representative_name" class="form-control"
                   value="{{ old('representative_name', $restaurant->representative_name) }}">
        </div>

        <div class="mb-3">
            <label>Representative Email</label>
            <input type="email" name="representative_email" class="form-control"
                   value="{{ old('representative_email', $restaurant->representative_email) }}">
        </div>

        <div class="mb-3">
            <label>Email (Restaurant Account)</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $restaurant->email) }}">
        </div>

        <div class="mb-3">
            <label>Restaurant Image</label>
            <input type="file" name="image_path" class="form-control">
            @if($restaurant->image_path)
                <small>Current: {{ $restaurant->image_path }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection