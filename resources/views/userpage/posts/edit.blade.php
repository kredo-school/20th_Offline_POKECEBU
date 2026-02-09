{{-- resources\views\userpage\posts\edit.blade.php --}}

@extends('layouts.user')

@section('title', 'Edit Post')

@section('content')
  <form action="{{ route('user.posts.update',$post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="create-post-page">
            <div class="create-post-card">
                <h3 class="mb-4"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Post</h3>


                {{-- categories --}}
                {{-- <div class="mb-3"> --}}
                {{-- <label for="category" class="form-label d-block fw-bold">
        Category <span class="text-muted fw-normal">(Up to 3)</span>
      </label>
      @php
        $all_categories = [
          (object)['id' => 1, 'name' => 'Food'],
          (object)['id' => 2, 'name' => 'Travel'],
          (object)['id' => 3, 'name' => 'Culture'],
        ];
      @endphp
      @foreach ($all_categories as $category)
        <div class="form-check form-check-inline">
          <input type="checkbox" name="category[]" id="{{ $category->name }}" class="form-check-input" value="{{ $category->id }}">
          <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
        </div>
      @endforeach
    </div> --}}
                {{-- title --}}
                <div class="form-group">
                    <label class="form-label fw-bold">title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter title"
                        value="{{ old('title', $post->title) }}">
                        @error('title')
                          <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                </div>

                {{-- body --}}
                <div class="form-group">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="body" id="body" rows="3" class="form-control" placeholder="What's on your mind?">{{ old('body', $post->body) }}</textarea>
                     @error('body')
                        <div class="text-danger small">{{ $message }}</div> 
                      @enderror
                </div>

                {{-- image --}}
                <div class="form-group">
                    <label class="form-label fw-bold">Image</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple aria-describedby="image-info">
                    <div class="form-text" id="image-info">
                        The acceptable formats are jpeg, jpg, png and gif only. <br>
                        Max file is 1048Kb.
                    </div>
                    @error('image')
                      <div class="text-danger small">{{ $message }}</div> 
                    @enderror
                </div>

                <button type="submit" class="btn post-btn">Post</button>
            </div>
        </div>
  </form>
@endsection


{{-- CSS --}}


<style>
    /* ページ全体 */
    .create-post-page {
        min-height: calc(100vh -64px);
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
