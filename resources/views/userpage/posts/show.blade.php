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

                {{-- 編集・削除 --}}
                @auth
                    @if (Auth::user()->id === $post->user->id)
                        <div class="dropdown text-end">
                            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('user.posts.edit', $post) }}" class="dropdown-item">
                                    Edit
                                </a>

                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>
                        @include('userpage.posts.modals.delete')
                     @endif
                @endauth

                <h2 class="mt-3">{{ $post->title }}</h2>

                <p class="text-muted small">{{ $post->user->name }} ・ {{ $post->created_at->format('M d, Y') }}</p>
                <hr>
                <p class="post-body"> {!! nl2br(e(preg_replace('/#[^\s#]+/u', '', $post->body))) !!}
                </p>
                <div class="post-tags mb-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('user.tags.show',$tag->name) }}" class="tag-badge">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>

               {{-- ハート --}}
                <div class="post-like">
                    
                    @if ($post->isliked())
                        <form action="{{ route('user.like.destroy', $post->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="heat-btn">
                               
                                <i class="fa-solid fa-heart text-danger"></i>
                            </button>
                        </form>    
                    @else
                        <form action="{{ route('user.like.store', $post->id )}}" method="post">
                            @csrf
                            <button type="submit" class="heat-btn"><i class="fa-regular fa-heart"></i></butt
                    @endif
                </div>


                <form action="{{ route('user.comment.store', $post->id) }}" method="post" class="comment-form">
                    @csrf
                    <div class="comment-input-wrapper">
                        <textarea name="comment_body{{ $post->id }}" rows="1" placeholder="Add a comment..." required>{{ old('comment_body' . $post->id) }}</textarea>
                        <button type="submit" class="send-comment-btn">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </div>
                    @error('comment_body' . $post->id)
                        <div class="text-danger xsmall mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
                 <div class="mb-2">
                    @if ($post->comments->isNotEmpty())
                        <ul class="list-group mt-2">
                            @foreach ($post->comments as $comment)
                                <li class="list-group-item border-0 p-0 mb-1">
                                    <span class="fw-bold">{{ $comment->user->name }}</span>:
                                    <span>{{ $comment->body }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- JS --}}
<script>
    // 表示されている画像を変える
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

    .tag-badge {
        text-decoration: none;
        display: inline-block;
        padding: 4px 10px;
        margin: 2px;
        font-size: 12px;
        border-radius: 20px;
        background: #e0f2ff;
        color: #0077cc;
        font-weight: 600;
    }

    /* ハート */
    .heat-btn {
        background: #ffffff;
        color: #333;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid #ddd;
        box-shadow: 0 2px 6px rgba(0,0,0,0.10);
        display: grid;
        place-items: center;
    }

</style>
