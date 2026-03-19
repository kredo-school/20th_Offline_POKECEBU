@extends('layouts.staff')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff.css/mypage/edit-hotel.css') }}">
@endpush

@section('content')
<div class="ig-main-container">
    <div class="ig-card">
        <div class="ig-card-header">
            <h2 class="ig-card-title">Edit Restaurant Information</h2>
            <p class="ig-card-subtitle">Update your restaurant's profile, contact details, and location.</p>
        </div>

        <form action="{{ route('restaurant.staff.update.restaurant') }}" method="POST" enctype="multipart/form-data" class="ig-form">
            @csrf

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

            {{-- 現在の画像表示 --}}
            <div class="ig-form-group">
                <label>Current Image</label>
                @if ($restaurant->images->isNotEmpty())
                    <div class="mb-2">
                        @foreach ($restaurant->images as $image)
                            <img src="{{ $image->image }}" alt="Current Restaurant Image"
                                style="width:150px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                        @endforeach
                    </div>
                @else
                    <p class="text-muted" style="font-size:13px;">No image registered.</p>
                @endif
            </div>

            {{-- ★変更: 複数画像アップロード (images[] + multiple) --}}
            <div class="ig-form-group">
                <label>Upload New Images <span class="text-muted" style="font-size:12px;">(Multiple selection allowed)</span></label>
                <div class="ig-file-upload">
                    <input type="file" name="images[]" id="restaurant_images" class="ig-input-file" multiple accept="image/*">
                    <p class="text-muted mt-1" style="font-size:12px;">You can select multiple images. They will replace existing ones after approval.</p>
                </div>
                {{-- プレビュー --}}
                <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-3"></div>
            </div>

            <div class="ig-form-footer">
                <a href="{{ route('restaurant.staff.mypage.restaurant') }}" class="ig-btn-secondary">Back</a>
                <button type="submit" class="ig-btn-primary">Save Changes</button>
            </div>
        </form>

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

<script>
    document.getElementById('restaurant_images').addEventListener('change', function(e) {
        const container = document.getElementById('image-preview-container');
        container.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.style = 'width:100px; height:80px; object-fit:cover; border-radius:6px; border:2px solid #4F8EF7;';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection