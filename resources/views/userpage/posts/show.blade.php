{{-- resources\views\userpage\mypage\post.blade.php --}}
@extends('layouts.user')

@section('title', 'Post-show')

@section('content')
    <div class="post-detail">

        {{-- 左：画像 --}}
        <div class="post-media">
            @if ($post->images->isNotEmpty())
                <img src="{{ $post->images->first()->image }}" alt="post id{{ $post->id }}" class="main-image" id="mainImage">
            @else
                <img src="{{ asset('images/Icon.png') }}" class="main-image" id="mainImage">
            @endif
        </div>
        <div class="thumbnail-row">
          @foreach ($post->images as $image)
              <img src="{{ $image->image }}" class="thumb img-fluid mb-2" onclick="changeImage(this)">
          @endforeach
        </div>

        {{-- 右：情報エリア --}}
        <div class="post-info">
            <div class="post-info-inner">

                {{-- メニュー --}}
                @auth
                    @if (Auth::user()->id === $post->user->id)
                        <div class="dropdown text-end">
                            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('user.posts.edit', $post) }}" class="dropdown-item">Edit</a>
                                
                                  <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                   Delete
                                  </button>
                               
                                
                              </div>
                            </div>
                        </div>
                    @endif
                @endauth
                <h2 class="mt-3">{{ $post->title }}</h2>

                <p class="text-muted small">{{ $post->user->name }} ・ {{ $post->created_at->format('M d, Y') }}</p>
                <p class="post-body">{{ $post->body }}</p>

            </div>
        </div>
    </div>

@endsection

<script>
    function changeImage(element) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = element.src;

        document.querySelectorAll('.thumb').forEach(img => {
            img.classList.remove('active');
        });

        element.classList.add('active');

    }
</script>

{{-- CSS --}}
<style>
    .post-detail {
      display: flex;
      height: calc(100vh - 80px);
      background: #F5f6f7;
      max-width: 1200px;
      margin: 0 auto;
      
    }

    /* 左：画像 */
    .post-media {
      flex: 1;
      background: #000;
      align-items: center;
      display: flex;
      justify-content: center;
      position: relative;
    }

    .main-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .thumbnail-row {
      position: absolute;
      bottom: 20px;
      display: flex;
      gap: 8px;
    }

    .thumb {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
      cursor: pointer;
      opacity: 0.8;
    }

    .thumb:hover {
      opacity: 1;
    }

    .thumb.active {
      border: 2px solid #007bff;
      opacity: 1;
    }

    /* 左：情報エリア */
    .post-info {
      width: 420px;
      background: #ffffff;
      overflow: auto;
      border-left: 1px solid #e5e5e5;
    }

    .post-info-inner {
      padding: 24px;
    }

    .post-body {
      line-height: 1.7;
    }
</style>
