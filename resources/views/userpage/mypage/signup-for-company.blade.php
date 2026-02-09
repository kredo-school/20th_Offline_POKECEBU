@extends('layouts.user')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="mb-1 text-primary"><i class="fa-solid fa-clipboard-list me-2"></i>Register Your Business</h2>
                    <p class="text-muted mb-0">Fill out the form below to request registration of a hotel or restaurant on
                        our platform.</p>
                </div>

                {{-- フラッシュメッセージ --}}
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                {{-- form --}}
                <form action="{{ route('user.mypage.signup-for-company.store') }}" method="post"
                    enctype="multipart/form-data" class="row g-4">
                    @csrf

                    {{-- ターゲット選択 --}}
                    <div class="col-12 d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="target type">
                            <input type="radio" class="btn-check" name="target_type" id="target_hotel" value="hotel"
                                autocomplete="off" {{ old('target_type', 'hotel') === 'hotel' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="target_hotel"><i class="fa-solid fa-hotel me-1"></i>
                                Hotel</label>

                            <input type="radio" class="btn-check" name="target_type" id="target_restaurant"
                                value="restaurant" autocomplete="off"
                                {{ old('target_type') === 'restaurant' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="target_restaurant"><i
                                    class="fa-solid fa-utensils me-1"></i> Restaurant</label>
                        </div>
                    </div>

                    {{-- Business Information --}}
                    <div class="col-12">
                        <div class="card shadow-sm border rounded">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="fw-bold">Business Information</strong>
                                    <div class="small text-muted">Provide accurate details for verification</div>
                                </div>
                                <div class="small text-muted">Fields marked <span class="text-danger">*</span> are required
                                </div>
                            </div>

                            <div class="card-body">
                                {{-- Company Name --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        placeholder="Enter company name" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Short description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Address / City --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Business Address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ old('address') }}" placeholder="Street address">
                                        @error('address')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">City</label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ old('city') }}" placeholder="City">
                                        @error('city')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Latitude / Longitude --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Latitude</label>
                                        <input type="text" name="latitude" class="form-control"
                                            value="{{ old('latitude') }}" placeholder="e.g. 10.3157">
                                        @error('latitude')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Longitude</label>
                                        <input type="text" name="longitude" class="form-control"
                                            value="{{ old('longitude') }}" placeholder="e.g. 123.8854">
                                        @error('longitude')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Star Rating / Phone / Website --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Star Rating</label>
                                        <input type="number" name="star_rating" class="form-control"
                                            value="{{ old('star_rating') }}" min="0" max="5" step="0.5"
                                            placeholder="0 - 5">
                                        @error('star_rating')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+63</span>
                                            <input type="tel" name="phone" class="form-control"
                                                value="{{ old('phone') }}" placeholder="Enter phone number">
                                        </div>
                                        @error('phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Website</label>
                                        <input type="url" name="website" class="form-control"
                                            value="{{ old('website') }}" placeholder="https://example.com">
                                        @error('website')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Representative --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Representative's Name</label>
                                        <input type="text" name="representative_name" class="form-control"
                                            value="{{ old('representative_name') }}"
                                            placeholder="Representative full name">
                                        @error('representative_name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email Address</label>
                                        <input type="email" name="representative_email" class="form-control"
                                            value="{{ old('representative_email') }}"
                                            placeholder="Business contact email">
                                        @error('representative_email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Images --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Business Images (optional)</label>
                                    <div id="imageInputs">
                                        <div class="input-group mb-2 image-input-group">
                                            <input type="file" name="images[]" class="form-control" accept="image/*">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm remove-image-btn">×</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2"
                                        onclick="addImageInput()">＋ 画像を追加</button>


                                    {{-- バリデーションエラー --}}
                                    @error('images')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @error('images.*')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror

                                    {{-- プレビュー --}}
                                    <div id="imagesPreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                                </div>

                            </div> {{-- card-body --}}
                        </div> {{-- card --}}
                    </div> {{-- col-12 --}}

                    {{-- Submit --}}
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg mt-3 px-5">
                            <i class="fa-solid fa-paper-plane me-2"></i>Register Now
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- スクリプト --}}
    @push('scripts')
        <script>
            let imageInputCounter = 0;

            function addImageInput() {
                const container = document.getElementById('imageInputs');
                const group = document.createElement('div');
                group.className = 'input-group mb-2 image-input-group';
                group.dataset.index = imageInputCounter;

                const input = document.createElement('input');
                input.type = 'file';
                input.name = 'images[]';
                input.className = 'form-control';
                input.accept = 'image/*';
                input.dataset.index = imageInputCounter;

                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-outline-danger btn-sm remove-image-btn';
                button.textContent = '×';
                button.dataset.index = imageInputCounter;

                group.appendChild(input);
                group.appendChild(button);
                container.appendChild(group);

                imageInputCounter++;
            }

            // 削除ボタンのイベント委譲（入力欄とプレビューを両方削除）
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-image-btn')) {
                    const index = e.target.dataset.index;
                    const inputGroup = document.querySelector(`.image-input-group[data-index="${index}"]`);
                    const previewImg = document.querySelector(`.preview-image[data-index="${index}"]`);
                    if (inputGroup) inputGroup.remove();
                    if (previewImg) previewImg.remove();
                }
            });

            // プレビュー機能（画像選択時）
            document.addEventListener('change', function(e) {
                if (e.target && e.target.type === 'file' && e.target.name === 'images[]') {
                    const file = e.target.files[0];
                    if (!file || !file.type.startsWith('image/')) return;

                    const preview = document.getElementById('imagesPreview');
                    const index = e.target.dataset.index;

                    // 既存のプレビューがあれば削除
                    const existing = document.querySelector(`.preview-image[data-index="${index}"]`);
                    if (existing) existing.remove();

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.width = '120px';
                        img.style.height = 'auto';
                        img.style.objectFit = 'cover';
                        img.className = 'border rounded preview-image';
                        img.dataset.index = index;
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
