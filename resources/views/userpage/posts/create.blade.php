@extends('layouts.user')

@section('title', 'Create Post')

@section('content')
    <div class="create-post-page">
        <div class="create-post-card">
            <h3 class="mb-4"><i class="fa-solid fa-pen-to-square me-2"></i>Create New Post</h3>

            <form action="{{ route('user.posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- title --}}
                <div class="form-group">
                    <label for="titel" class="form-label fw-bold">title</label>
                    <input type="text" name="title" id="title" class="form-control soft-input"
                        placeholder="Enter title" value="{{ old('title') }}">
                </div>

                {{-- body --}}
                <div class="form-group">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="body" id="body" rows="3" class="form-control soft-input"
                        placeholder="What's on your mind?">{{ old('body') }}</textarea>
                </div>

                {{-- image --}}
                <div class="form-group">
                    <label class="form-label fw-bold">Image (max 5)</label>
                    <div class="image-upload-wrapper">
                        <div id="preview-container"></div>


                        <label class="upload-box">
                            <i class="fa-solid fa-camera"></i>
                            <span id="image-count">0 / 5</span>
                            <input type="file" name="images[]" id="image" class="form-control soft-file" multiple
                                accept="image/jpeg,image/png,image/gif" hidden>
                        </label>
                    </div>
                    <div class="form-text" id="image-info">
                        The acceptable formats are jpeg, jpg, png and gif only. <br>
                        Max file is 2048Kb.
                    </div>
                </div>

                <button type="submit" class="btn post-btn">Post</button>
            </form>
        </div>
    </div>
@endsection


{{-- CSS --}}


<style>
    /* ページ全体 */
    .create-post-page {
        min-height: calc(100vh - 64px);
        background: linear-gradient(180deg,
                #f0f8fb 0%,
                #e6f5f8 50%,
                #ffffff 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 16px;
    }

    /* カード */
    .create-post-card {
        width: 100%;
        max-width: 520px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(8px);
    }

    /* タイトル */
    .page-title {
        text-align: center;
        font-size: 24px;
        font-weight: 600;
        color: #2f4f6f;
        margin-bottom: 24px;
    }

    .page-title i {
        margin-right: 8px;
    }

    /* フォーム */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-size: 14px;
        color: #4a647f;
        margin-bottom: 6px;
    }

    /* 入力欄 */
    .soft-input {
        border-radius: 12px;
        border: 1px solid #e0e8f0;
        padding: 10px 14px;
        font-size: 14px;
    }

    .soft-input:focus {
        border-color: #6fa9de;
        box-shadow: 0 0 0 3px rgba(111, 169, 222, 0.2);
    }

    /* ファイル */
    .soft-file {
        border-radius: 12px;
        font-size: 14px;
    }

    .image-upload-wrapper {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    #preview-container {
        display: flex;
        gap: 12px;
    }

    .preview-box {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 14px;
        overflow: hidden;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.64);
        color: #ffffff;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        cursor: pointer;
    }

    .upload-box {
        width: 100px;
        height: 100px;
        border: 2px dashed #d0dbe8;
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        color: #6fa9de;
    }


    /* 投稿ボタン */
    .post-btn {
        background: linear-gradient(to right,
                #6fa9de,
                #51c9d0);
        color: #ffffff;
        padding: 10px 36px;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 500;
        border: none;
    }

    .post-btn:hover {
        opacity: 0.9;
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const input = document.getElementById('image');
            const previewContainer = document.getElementById('preview-container');
            const countText = document.getElementById('image-count');

            const dataTransfer = new DataTransfer();

            input.addEventListener('change', function(e) {

                const files = Array.from(e.target.files);

                files.forEach(file => {

                    if (dataTransfer.files.length >= 5) return;

                    dataTransfer.items.add(file);

                    const reader = new FileReader();

                    reader.onload = function(event) {

                        const box = document.createElement('div');
                        box.classList.add('preview-box');

                        box.innerHTML = `
                    <img src="${event.target.result}" style="width:100%;height:100%;object-fit:cover;">
                    <button type="button" class="remove-btn">&times;</button>
                `;

                        box.querySelector('.remove-btn').onclick = function() {

                            const index = Array.from(dataTransfer.files)
                                .findIndex(f => f.name === file.name);

                            dataTransfer.items.remove(index);
                            input.files = dataTransfer.files;

                            box.remove();
                            updateCount();
                        };

                        previewContainer.appendChild(box);
                        updateCount();
                    };

                    reader.readAsDataURL(file);
                });

                input.files = dataTransfer.files;

            });

            function updateCount() {
                countText.textContent = dataTransfer.files.length + " / 5";
            }

        });
    </script>
@endpush
