{{-- resources\views\userpage\posts\edit.blade.php --}}

@extends('layouts.user')

@section('title', 'Edit Post')

@section('content')
<div class="container py-4">
  @php
    // ダミーデータ
    $post = (object)[
      'id' => 1,
      'description' => 'これは既存の投稿の説明文です',
      'image' => asset('images/sample.png'),
    ];

    $all_categories = [
      (object)['id' => 1, 'name' => 'Food'],
      (object)['id' => 2, 'name' => 'Travel'],
      (object)['id' => 3, 'name' => 'Culture'],
    ];

    $selected_categories = [1, 3]; // Food と Culture が選択済み
  @endphp

  <h3 class="mb-4"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Post</h3>

  <form action="#" method="post" enctype="multipart/form-data">
    {{-- CSRFやPATCHは省略（ビュー確認用） --}}

    {{-- categories --}}
    <div class="mb-3">
      <label for="category" class="form-label d-block fw-bold">
        Category <span class="text-muted fw-normal">(Up to 3)</span>
      </label>

      @foreach ($all_categories as $category)
        <div class="form-check form-check-inline">
          <input type="checkbox" name="category[]" id="{{ $category->name }}" class="form-check-input"
                 value="{{ $category->id }}"
                 @if(in_array($category->id, $selected_categories)) checked @endif>
          <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
        </div>
      @endforeach
    </div>

    {{-- description --}}
    <div class="mb-3">
      <label for="description" class="form-label fw-bold">Description</label>
      <textarea name="description" id="description" rows="3" class="form-control"
                placeholder="What's on your mind?">{{ $post->description }}</textarea>
    </div>

    {{-- image --}}
    <div class="mb-4">
      <div class="col-6">
        <label for="image" class="form-label fw-bold">Image</label>
        <img src="{{ $post->image }}" alt="Post Image" class="img-thumbnail w-100 mb-2">
        <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
        <div class="form-text" id="image-info">
          The acceptable formats are jpeg, jpg, png and gif only. <br>
          Max file is 1048Kb.
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary px-5">Save</button>
  </form>
</div>
@endsection