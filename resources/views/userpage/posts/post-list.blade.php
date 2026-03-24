{{-- resources\views\userpage\posts\show.blade.php --}}
@extends('layouts.user')

@section('title', 'Show Post')

@section('content')
<div class="post-body">
  {{-- ヘッダー --}}
  <div class="container">
    {{-- ヘッダー --}}
    <div class="top-photo"><h1>SHARE YOUR CEBU</h1></div>

    {{-- タグエリア（人気キーワードなど） --}}
    <div class="keyword-section">
      <div class="keyword-header">
        <span class="line"></span>
        <h3>KEYWORD</h3>
        <span class="line"></span>
      </div>
      <div class="keyword-tags">
        @foreach ($popularTags as $tag)
          <a href="{{ route('user.posts.index', ['search' => $tag->name]) }}" class="keyword-tag">
            #{{ $tag->name }}
          </a>
        @endforeach
      </div>
    </div>

    {{-- 検索エリア & ヘッダーナビ --}}
    <div class="search-1 mb-4">
      <div class="d-flex justify-content-between align-items-center">

        {{-- 左側：タイトルエリア（可変） --}}
        <h2 class="post-title mb-0" style="white-space: nowrap;">
          @if(isset($search_word) && $search_word !== '')
            #{{ $search_word }}
          @else
            All posts
          @endif
          <span class="post-count text-muted">({{ $posts->count() }})</span>
        </h2>

        {{-- 右側：操作エリア（固定・右寄せ） --}}
        <div class="d-flex align-items-center gap-3">

          {{-- 検索ボックスとリセット --}}
          <div class="d-flex align-items-center">
            <form action="{{ route('user.posts.index') }}" method="GET" class="position-relative mb-0"
              style="width: 250px;">
              <input type="text" name="search" class="form-control search-input" placeholder="Search for tags..."
                value="{{ $search_word ?? '' }}" style="border-radius: 25px; padding-right: 40px; font-size: 0.9rem;">
              <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent">
                <i class="fas fa-search text-muted"></i>
              </button>
            </form>
            <a href="{{ route('user.posts.index') }}" class="ms-2 text-muted small text-decoration-none" title="reset">
              <i class="fas fa-times-circle fa-lg"></i>
            </a>
          </div>

          {{-- 投稿ボタン --}}
          <a href="{{ route('user.posts.create') }}" class="add-post-btn mb-0" style="white-space: nowrap;">
            + Add Post
          </a>
        </div>
      </div>
    </div>

    {{-- ポスト一覧（検索結果） --}}
    <div class="row">
      @forelse ($posts as $post)
        <div class="col-md-6 col-lg-4 mb-4">
          <a href="{{ route('user.posts.show', $post->id) }}" class="post-link">
            <div class="card post-card h-100">
              @if ($post->images->isNotEmpty())
                <img src="{{ $post->images->first()->image }}" alt="Post Image" class="card-img-top img-fluid">
              @endif

              <div class="card-body pb-1">
                <div class="post-main">
                  <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                  <p class="card-text">
                    {!! nl2br(e(preg_replace('/#[^\s#]+/u', '', $post->body))) !!}
                  </p>
                </div>

                <div class="post-meta">
                  <p class="post-user mb-1">{{ $post->user->name }}</p>
                  <p class="post-date">{{ $post->created_at->format('M d, Y') }}</p>
                  <div class="post-tags mb-2">
                    @foreach ($post->tags as $tag)
                      <span class="tag-badge">#{{ $tag->name }}</span>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">No posts found.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>

{{-- CSS --}}
<style>
  .post-body {
    background: linear-gradient(180deg,
        #f0f8fb 0%,
        #e6f5f8 50%,
        #ffffff 100%);
  }

  /* ヘッダー */
  .post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 40px 0 20px;
  }

  .post-title {
    font-size: 22px;
    letter-spacing: 3px;
    font-weight: 600;
  }

  .add-post-btn {
    padding: 10px 20px;
    border-radius: 999px;
    background: #f4a261;
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: all .2s;
  }

  .add-post-btn:hover {
    background: #e76f51;
    transform: translateY(-2px);
  }

  /* カード */
  .post-card {
    height: 420px;
    display: flex;
    flex-direction: column;
    border-radius: 25px;
    background: #ffffff;
    border: none;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transition: transfrom 0.3 ease, box-shadow 0.3s ease;
    cursor: pointer;
  }

  .post-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(0, 0, 0, 0.12)
  }

  .post-card img {
    height: 220px;
    object-fit: cover;
  }

  .post-meta {
    margin-top: auto;
  }

  .card-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .post-user {
    font-weight: 600;
    color: #2c7da0;
  }

  .post-date {
    font-size: 0.85rem;
    color: #8dbcd8;
  }

  .post-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .post-tags {
    height: 63px;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
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

  .top-photo {
    width: 100%;
    height: 200px;
    margin-bottom: 20px;
    background-image: url("{{ asset('images/home-post.jpg') }}");
    background-size: cover;
    background-position: center 70%;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.1);
    background-blend-mode: multiply;
  }

  .top-photo h1 {
    font-size: 3em;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    margin: 0;
    position: relative;
    z-index: 2;
  }

  /* ===== KEYWORDエリア ===== */
  .keyword-section {
    text-align: center;
    margin: 50px 0 40px;
  }

  /* タイトル */
  .keyword-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-bottom: 25px;
  }

  .keyword-header h3 {
    font-weight: 600;
    letter-spacing: 4px;
    font-size: 20px;
    color: #444;
  }

  /* 左右ライン */
  .keyword-header .line {
    height: 2px;
    width: 120px;
    background: #6c757d;
  }

  /* タグエリア */
  .keyword-tags {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px 16px;
    align-items: flex-start;
    height: 97px;
    overflow: hidden;
  }

  /* タグデザイン */
  .keyword-tag {
    padding: 8px 18px;
    border-radius: 30px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #555;
    font-size: 14px;
    transition: all .25s ease;
  }

  /* hover */
  .keyword-tag:hover {
    background: #5bc0de;
    border-color: #5bc0de;
    color: white;
  }

  /* 検索ボックスのスタイル */
  .search-input {
    border-radius: 20px 0 0 20px;
    border: 1px solid #ced4da;
    padding-left: 20px;
  }

  .btn-search {
    border-radius: 0 20px 20px 0;
    background-color: #2c7da0;
    color: white;
    border: none;
    padding: 0 20px;
  }

  .btn-search:hover {
    background-color: #1a5c7a;
    color: white;
  }

  .post-count {
    font-size: 1.2rem;
  }

  /* レスポンシブ調整 */
  @media (max-width: 768px) {
    .search-box {
      order: 3;
      /* スマホ時は検索ボックスを一番下に */
      width: 100%;
    }
}
</style>
@endsection