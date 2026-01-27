{{-- resources\views\userpage\posts\create.blade.php --}}
@extends('layouts.user')

@section('title', 'Create Post')

@section('content')
<div class="container py-4">
  <h3 class="mb-4"><i class="fa-solid fa-pen-to-square me-2"></i>Create New Post</h3>

  <form action="#" method="post" enctype="multipart/form-data">
    {{-- CSRFは未使用のため省略 --}}
    
    {{-- categories --}}
    <div class="mb-3">
      <label for="category" class="form-label d-block fw-bold">
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
    </div>

    {{-- description --}}
    <div class="mb-3">
      <label for="description" class="form-label fw-bold">Description</label>
      <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind?"></textarea>
    </div>

    {{-- image --}}
    <div class="mb-4">
      <label for="image" class="form-label fw-bold">Image</label>
      <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
      <div class="form-text" id="image-info">
        The acceptable formats are jpeg, jpg, png and gif only. <br>
        Max file is 1048Kb.
      </div>
    </div>

    <button type="submit" class="btn btn-primary px-5">Post</button>
  </form>
</div>
@endsection