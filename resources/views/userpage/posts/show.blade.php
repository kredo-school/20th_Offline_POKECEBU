@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/posts/show.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
@endpush

@section('title', 'Post')

@section('content')
<div class="post-body">
    {{-- Backボタン --}}
   <div class="back-bar">
    <a href="{{ route('user.posts.index') }}" class="back-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Back
    </a>
    </div>
    <div class="post-detail">

        {{-- ── 左：メディア ── --}}
        <div class="post-media" id="postMediaContainer">
            <div class="media-slider" id="mediaSlider">
                @if ($post->images->isNotEmpty())
                    @foreach ($post->images as $i => $image)
                        <div class="slide" data-index="{{ $i }}">
                            <img src="{{ $image->image }}" alt="post-{{ $post->id }}-{{ $i }}">
                        </div>
                    @endforeach
                @else
                    <div class="slide" data-index="0">
                        <img src="{{ asset('images/Icon.png') }}" alt="post">
                    </div>
                @endif
            </div>

            @if ($post->images->count() > 1)
                <button class="nav-arrow nav-prev" id="navPrev" aria-label="Previous">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </button>
                <button class="nav-arrow nav-next" id="navNext" aria-label="Next">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </button>
                <div class="slide-dots" id="slideDots">
                    @foreach ($post->images as $i => $image)
                        <span class="dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ── 右：情報 ── --}}
        <div class="post-info">

            {{-- ヘッダー --}}
            <div class="post-info-header">
                <div class="post-info-author">
                    <div class="post-author-avatar">
                        @if ($post->user->detail?->avatar && str_starts_with($post->user->detail->avatar, 'data:'))
                            <img src="{{ $post->user->detail->avatar }}" alt="avatar">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                    <div>
                        <div class="post-author-name">{{ $post->user->name }}</div>
                        <div class="post-author-date">{{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

                @auth
                    @if (Auth::user()->id === $post->user->id)
                        <div class="dropdown">
                            <button class="post-dropdown-btn" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('user.posts.edit', $post) }}" class="dropdown-item">
                                    <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                                </a>
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                    <i class="fa-regular fa-trash-can me-2"></i>Delete
                                </button>
                            </div>
                        </div>
                        @include('userpage.posts.modals.delete')
                    @endif
                @endauth
            </div>

            {{-- スクロールエリア --}}
            <div class="post-info-scroll" id="postInfoScroll">
                <div class="post-info-inner">

                    {{-- キャプション --}}
                    <div class="post-caption">
                        <div class="caption-avatar">
                            @if ($post->user->detail?->avatar && str_starts_with($post->user->detail->avatar, 'data:'))
                                <img src="{{ $post->user->detail->avatar }}" alt="avatar">
                            @else
                                <i class="fa-solid fa-user"></i>
                            @endif
                        </div>
                        <div class="caption-body">
                            <span class="caption-username">{{ $post->user->name }}</span>
                            <span class="caption-title">{{ $post->title }}</span>
                            <p class="caption-text">{!! nl2br(e(preg_replace('/#[^\s#]+/u', '', $post->body))) !!}</p>
                        </div>
                    </div>

                    {{-- コメント --}}
                    @if ($post->comments->isNotEmpty())
                        <ul class="comment-list">
                            @foreach ($post->comments as $comment)
                                <li class="comment-item">
                                    <div class="comment-avatar">
                                        @if ($comment->user->detail?->avatar && str_starts_with($comment->user->detail->avatar, 'data:'))
                                            <img src="{{ $comment->user->detail->avatar }}" alt="avatar">
                                        @else
                                            <i class="fa-solid fa-user"></i>
                                        @endif
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <span class="comment-username">{{ $comment->user->name }}</span>
                                            @auth
                                                @if (Auth::user()->id === $post->user->id)
                                                    <div class="dropdown ms-auto">
                                                        <button class="comment-dropdown-btn" data-bs-toggle="dropdown">
                                                            <i class="fa-solid fa-ellipsis"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <form action="{{ route('user.comment.destroy', $comment->id) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="comment-body-text">{{ $comment->body }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div id="commentBottom"></div>
                </div>
            </div>

            {{-- 固定フッター --}}
            <div class="post-info-fixed">

                {{-- アクションバー --}}
                <div class="action-bar">
                    <div class="action-left">
                        <button
                            class="action-btn {{ $post->isliked() ? 'liked' : '' }}"
                            id="likeBtn"
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $post->isliked() ? 'true' : 'false' }}"
                            data-store-url="{{ route('user.like.store', $post->id) }}"
                            data-destroy-url="{{ route('user.like.destroy', $post->id) }}"
                            data-csrf="{{ csrf_token() }}">
                            <i class="{{ $post->isliked() ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        </button>
                        <button class="action-btn" onclick="document.querySelector('.comment-input-wrapper textarea').focus()">
                            <i class="fa-regular fa-comment"></i>
                        </button>
                    </div>
                </div>

                <div class="like-count-area">
                    <span class="like-count">{{ $post->likes->count() }} likes</span>
                </div>

                @if ($post->tags->isNotEmpty())
                    <div class="post-tags-bar">
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('user.tags.show', $tag->name) }}" class="tag-badge">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

                <div class="comment-form-area">
                    <form action="{{ route('user.comment.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="comment-input-wrapper">
                            <textarea name="comment_body{{ $post->id }}" rows="1" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
                            <button type="submit" class="send-comment-btn">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ── スライダー ──
        const slider = document.getElementById('mediaSlider');
        const slides = Array.from(document.querySelectorAll('.slide'));
        const dots   = Array.from(document.querySelectorAll('.dot'));
        const prev   = document.getElementById('navPrev');
        const next   = document.getElementById('navNext');

        if (!slider || slides.length <= 1) {
            if (prev) prev.style.display = 'none';
            if (next) next.style.display = 'none';
        }

        if (!slider || slides.length === 0) return;

        let current = 0;

        function goTo(index) {
            if (index < 0 || index >= slides.length) return;
            slider.style.transform = `translateX(${index * -100}%)`;
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
            current = index;
            updateArrows();
        }

        function updateArrows() {
            if (prev) prev.style.display = current === 0 ? 'none' : 'flex';
            if (next) next.style.display = current === slides.length - 1 ? 'none' : 'flex';
        }

        if (prev) prev.addEventListener('click', () => goTo(current - 1));
        if (next) next.addEventListener('click', () => goTo(current + 1));
        dots.forEach(d => d.addEventListener('click', () => goTo(parseInt(d.dataset.index))));

        let startX = 0;
        slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
        slider.addEventListener('touchend', e => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
        });

        updateArrows();

        @if (session('comment_posted'))
            const el = document.getElementById('postInfoScroll');
            if (el) el.scrollTop = el.scrollHeight;
        @endif

        // ── いいね Ajax ──
        const likeBtn = document.getElementById('likeBtn');
        if (likeBtn) {
            likeBtn.addEventListener('click', async function () {
                const liked   = this.dataset.liked === 'true';
                const url     = liked ? this.dataset.destroyUrl : this.dataset.storeUrl;
                const method  = liked ? 'DELETE' : 'POST';
                const csrf    = this.dataset.csrf;
                const icon    = this.querySelector('i');
                const counter = document.querySelector('.like-count');

                const newLiked = !liked;
                this.dataset.liked = newLiked ? 'true' : 'false';
                this.classList.toggle('liked', newLiked);
                icon.className = newLiked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';

                const currentCount = parseInt(counter.textContent);
                counter.textContent = (newLiked ? currentCount + 1 : currentCount - 1) + ' likes';

                try {
                    const res = await fetch(url, {
                        method,
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    });
                    if (!res.ok) throw new Error('failed');
                } catch (e) {
                    this.dataset.liked = liked ? 'true' : 'false';
                    this.classList.toggle('liked', liked);
                    icon.className = liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                    counter.textContent = currentCount + ' likes';
                }
            });
        }
    });
</script>
@endpush

<style>
    .post-body {
    background: linear-gradient(180deg,
        #f0f8fb 0%,
        #e6f5f8 50%,
        #ffffff 100%);
    }
</style>
@endsection