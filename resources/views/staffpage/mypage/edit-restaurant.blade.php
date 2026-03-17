@extends('layouts.staff')

@push('styles')
    {{-- ホテル版と共通のCSSを使用 --}}
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card">
        {{-- Header Section --}}
        <div class="ig-card-header">
            <h2 class="ig-card-title">Edit Restaurant Information</h2>
            <p class="ig-card-subtitle">Update your restaurant's profile, contact details, and location.</p>
        </div>

        {{-- Form Section --}}
        <form action="{{ route('restaurant.staff.update.restaurant') }}" method="POST" enctype="multipart/form-data" class="ig-form">
            @csrf

            {{-- Basic Information --}}
            <div class="ig-form-group">
                <label>Restaurant Name</label>
                <input type="text" name="name" class="ig-input" value="{{ old('name', $restaurant->name) }}" placeholder="Enter restaurant name">
            </div>

            <div class="ig-form-group">
                <label>Description</label>
                <textarea name="description" class="ig-input ig-textarea" placeholder="Describe your restaurant's concept...">{{ old('description', $restaurant->description) }}</textarea>
            </div>

            <div class="ig-grid-row">
                <div class="ig-form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="ig-input" value="{{ old('phone', $restaurant->phone) }}" placeholder="e.g. +63 123 456 789">
                </div>
            </div>

            <div class="ig-form-group">
                <label>Official Website</label>
                <input type="text" name="website" class="ig-input" value="{{ old('website', $restaurant->website) }}" placeholder="https://example.com">
            </div>

            {{-- Location Information --}}
            <div class="ig-form-group">
                <label>Address</label>
                <input type="text" name="address" class="ig-input" value="{{ old('address', $restaurant->address) }}" placeholder="Street, Building name">
            </div>

            <div class="ig-grid-row">
                <div class="ig-form-group">
                    <label>City</label>
                    <input type="text" name="city" class="ig-input" value="{{ old('city', $restaurant->city) }}" placeholder="City name">
                </div>
                <div class="ig-form-group">
                    <label>Email (Restaurant Account)</label>
                    <input type="email" name="email" class="ig-input" value="{{ old('email', $restaurant->email) }}" placeholder="restaurant@example.com">
                </div>
            </div>

            <div class="ig-grid-row">
                <div class="ig-form-group">
                    <label>Latitude</label>
                    <input type="number" step="any" name="latitude" class="ig-input" value="{{ old('latitude', $restaurant->latitude) }}">
                </div>
                <div class="ig-form-group">
                    <label>Longitude</label>
                    <input type="number" step="any" name="longitude" class="ig-input" value="{{ old('longitude', $restaurant->longitude) }}">
                </div>
            </div>

            {{-- Representative Information --}}
            <div class="ig-grid-row">
                <div class="ig-form-group">
                    <label>Representative Name</label>
                    <input type="text" name="representative_name" class="ig-input" value="{{ old('representative_name', $restaurant->representative_name) }}">
                </div>
                <div class="ig-form-group">
                    <label>Representative Email</label>
                    <input type="email" name="representative_email" class="ig-input" value="{{ old('representative_email', $restaurant->representative_email) }}">
                </div>
            </div>

            {{-- Image Upload --}}
            <div class="ig-form-group">
                <label>Restaurant Image</label>
                <div class="ig-file-upload">
                    <input type="file" name="image_path" class="ig-input-file">
                    @if ($restaurant->image_path)
                        <div class="ig-current-image">
                            Current file is stored. Upload new to replace.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="ig-form-footer">
                <a href="{{ route('restaurant.staff.mypage.restaurant') }}" class="ig-btn-secondary">Back</a>
                <button type="submit" class="ig-btn-primary">Save Changes</button>
            </div>
        </form>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="ig-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection