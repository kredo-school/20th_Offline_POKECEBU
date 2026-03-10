@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
@endpush

@section('content')
    <div class="ig-main-container">
        <div class="ig-card">
            {{-- Header Section --}}
            <div class="ig-card-header">
                <h2 class="ig-card-title">Edit Hotel Information</h2>
                <p class="ig-card-subtitle">Update your hotel's profile, contact details, and location settings.</p>
            </div>

            {{-- Form Section --}}
            <form action="{{ route('staff.mypage.hotel.store') }}" method="POST" enctype="multipart/form-data"
                class="ig-form">
                @csrf

                {{-- Basic Information --}}
                <div class="ig-form-group">
                    <label>Hotel Name</label>
                    <input type="text" name="name" class="ig-input" value="{{ old('name', $hotel->name) }}"
                        placeholder="Enter hotel name">
                </div>

                <div class="ig-form-group">
                    <label>Description</label>
                    <textarea name="description" class="ig-input ig-textarea" placeholder="Describe your hotel...">{{ old('description', $hotel->description) }}</textarea>
                </div>

                <div class="ig-grid-row">
                    <div class="ig-form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="ig-input" value="{{ old('phone', $hotel->phone) }}"
                            placeholder="e.g. +63 123 456 789">
                    </div>
                </div>

                <div class="ig-form-group">
                    <label>Official Website</label>
                    <input type="text" name="website" class="ig-input" value="{{ old('website', $hotel->website) }}"
                        placeholder="https://example.com">
                </div>

                {{-- Location Information --}}
                <div class="ig-form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="ig-input" value="{{ old('address', $hotel->address) }}"
                        placeholder="Street, Building name">
                </div>

                <div class="ig-grid-row">
                    <div class="ig-form-group">
                        <label>City</label>
                        <input type="text" name="city" class="ig-input" value="{{ old('city', $hotel->city) }}"
                            placeholder="City name">
                    </div>
                    <div class="ig-form-group">
                        <label>Email (Hotel Account)</label>
                        <input type="email" name="email" class="ig-input" value="{{ old('email', $hotel->email) }}"
                            placeholder="hotel@example.com">
                    </div>
                </div>

                <div class="ig-grid-row">
                    <div class="ig-form-group">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="ig-input"
                            value="{{ old('latitude', $hotel->latitude) }}">
                    </div>
                    <div class="ig-form-group">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="ig-input"
                            value="{{ old('longitude', $hotel->longitude) }}">
                    </div>
                </div>

                {{-- Representative Information --}}
                <div class="ig-grid-row">
                    <div class="ig-form-group">
                        <label>Representative Name</label>
                        <input type="text" name="representative_name" class="ig-input"
                            value="{{ old('representative_name', $hotel->representative_name) }}">
                    </div>
                    <div class="ig-form-group">
                        <label>Representative Email</label>
                        <input type="email" name="representative_email" class="ig-input"
                            value="{{ old('representative_email', $hotel->representative_email) }}">
                    </div>
                </div>

                {{-- Image Upload --}}
                <div class="ig-form-group">
                    <label>Hotel Image</label>
                    <div class="ig-file-upload">
                        <input type="file" name="image_path" id="hotel_image" class="ig-input-file">
                        @if ($hotel->image_path)
                            <div class="ig-current-image">
                                Current file: <strong>{{ $hotel->image_path }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="ig-form-footer">
                    {{-- 特定のマイページへ飛ばす設定 --}}
                    <a href="{{ route('staff.mypage.hotel') }}" class="ig-btn-secondary">Back</a>

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
