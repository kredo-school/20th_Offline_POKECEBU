@extends('layouts.user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/post.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
   
@endpush

@section('content')
<div class="mypage-wrapper">

    {{-- 左サイドバー（mypageと同一構造） --}}
    <aside class="ig-sidebar">
        <div class="ig-sidebar-profile">
            <div class="ig-sidebar-avatar">
                <div class="ig-sidebar-avatar-inner">
                    @if ($user->detail?->avatar)
                        <img src="{{ $user->detail->avatar }}" alt="avatar">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                </div>
            </div>
            <div class="ig-sidebar-name">
                {{ $user->detail?->first_name ?? '' }} {{ $user->detail?->last_name ?? 'ユーザー' }}
            </div>
            <div class="ig-sidebar-email">{{ $user->email }}</div>
        </div>

        <nav class="ig-sidebar-nav">
            <a href="{{ route('mypage') }}" class="ig-nav-item">
                <i class="fa-regular fa-user"></i> Profile
            </a>
            <a href="{{ route('user.mypage.post') }}" class="ig-nav-item active">
                <i class="fa-regular fa-images"></i> Posts
            </a>
            <a href="{{ route('booking') }}" class="ig-nav-item">
                <i class="fa-regular fa-calendar"></i> Bookings
            </a>
            <a href="{{ route('favorite') }}" class="ig-nav-item">
                <i class="fa-regular fa-heart"></i> Favorite
            </a>
        </nav>
    </aside>

    {{-- 右コンテンツ --}}
    <main class="ig-content">

        {{-- ヘッダーカード（mypageのig-profile-cardと同じ構造） --}}
        <div class="ig-profile-card">
            <div class="ig-profile-card-left">
                <div class="ig-avatar-ring">
                    <div class="ig-avatar-inner">
                        @if ($user->detail?->avatar)
                            <img src="{{ $user->detail->avatar }}" alt="avatar">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="ig-profile-info">
                    <div class="ig-username">
                        <span>{{ $user->detail?->first_name ?? '' }} {{ $user->detail?->last_name ?? 'ユーザー' }}</span>
                    </div>
                    <div class="ig-email">{{ $home_posts->total() }} posts</div>
                </div>
            </div>
            <a href="{{ route('user.posts.create') }}" class="ig-new-post-btn">
                <i class="fa-solid fa-plus"></i> New Post
            </a>
        </div>

        @if ($home_posts->isNotEmpty())

            {{-- グリッド --}}
            <div class="ig-grid">
                @foreach ($home_posts as $post)
                    <div class="ig-grid-item">

                        @if ($post->images->isNotEmpty())
                            <img src="{{ $post->images->first()->image }}" alt="{{ $post->title }}">
                            @if ($post->images->count() > 1)
                                <span class="ig-multi-badge"><i class="fa-solid fa-clone"></i></span>
                            @endif
                        @else
                            <div class="ig-grid-no-img">
                                <i class="fa-regular fa-image"></i>
                            </div>
                        @endif

                        <a href="{{ route('user.posts.show', $post) }}" class="ig-grid-overlay">
                            <span class="ig-overlay-stat">
                                <i class="fa-solid fa-heart"></i> {{ $post->likes->count() ?? 0 }}
                            </span>
                            <span class="ig-overlay-stat">
                                <i class="fa-solid fa-comment"></i> {{ $post->comments->count() ?? 0 }}
                            </span>
                        </a>

                        <div class="ig-post-actions">
                            <a href="{{ route('user.posts.edit', $post) }}" class="ig-action-btn">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('user.posts.destroy', $post) }}" method="POST" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="ig-action-btn delete"
                                    onclick="return confirm('削除しますか？')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="ig-pagination">
                {{ $home_posts->links() }}
            </div>

        @else
            <div class="ig-empty">
                <div class="ig-empty-icon">
                    <i class="fa-regular fa-camera"></i>
                </div>
                <h3>No Posts Yet</h3>
                <p>When you share a post, each post will be displayed individually.</p>
                <a href="{{ route('user.posts.create') }}" class="ig-new-post-btn" style="display:inline-flex;">
                    <i class="fa-solid fa-plus"></i> Create a new post 
                </a>
            </div>
        @endif

    </main>
</div>
@endsection