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
            <form action="{{ route('hotel.staff.mypage.hotel.store') }}" method="POST" enctype="multipart/form-data"
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

                {{-- 現在の画像表示 --}}
                <div class="ig-form-group">
                    <label>Current Image</label>
                    @if ($hotel->images->isNotEmpty())
                        <div class="mb-2">
                            @foreach ($hotel->images as $image)
                                    <img src="{{ $image->image }}" alt="Current Hotel Image"
                                        style="width:150px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted" style="font-size:13px;">No image registered.</p>
                    @endif
                </div>

                {{-- 複数画像アップロード --}}
                <div class="ig-form-group">
                    <label>Upload New Images <span class="text-muted" style="font-size:12px;">（Multiple selections allowed）</span></label>
                    <div class="ig-file-upload">
                        <input type="file" name="images[]" id="hotel_images" class="ig-input-file" multiple accept="image/*">
                        <p class="text-muted mt-1" style="font-size:12px;">You can select multiple images. They will replace existing ones after approval.</p>
                    </div>
                    {{-- プレビュー --}}
                    <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-3"></div>
                </div>

                {{-- Footer Buttons --}}
                <div class="ig-form-footer">
                    <a href="{{ route('hotel.staff.mypage.hotel') }}" class="ig-btn-secondary">Back</a>
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

    {{-- 画像プレビュー用JS --}}
    <script>
        document.getElementById('hotel_images').addEventListener('change', function(e) {
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