{{-- resources\views\userpage\posts\show.blade.php --}}
@extends('layouts.user')

@section('title', 'Show Post')

@section('content')
{{-- ヘッダー --}}
<div class="page-header">
  <div class="header-text">
    {{ $tag->name }}
  </div>
  <a href="{{ route('user.posts.create') }}" class="add-post-btn">
    + Add new post
  </a>
</div>

{{-- ポスト --}}
<div class="container py-4">
  <div class="row">
    @foreach ($posts as $post)
      <div class="col-md-6 col-lg-4 mb-4">
        <a href="{{ route('user.posts.show',$post->id) }}" class="post-link">
        <div class="card post-card h-100">
          @if ($post->images->isNotEmpty())
            <img src="{{ $post->images->first()->image }}" alt="Post Image" class="card-img-top img-fluid">
          @endif

          <div class="card-body">
            {{-- ポスト内容：上 --}}
            <div class="post-main">
              <h5 class="card-title">{{ $post->title }}</h5>
              <p class="card-text">
                {!! nl2br(e(preg_replace('/#[^\s#]+/u', '', $post->body))) !!}

            </p>
            </div>
            
            {{-- ポスト内容：下 --}}
            <div class="post-meta">
              <p class="post-user mb-1">{{ $post->user->name }}</p>
              <p class="post-date">{{ $post->created_at->format('M d, Y') }}</p>
              <div class="post-tags mb-2">
                @foreach ($post->tags as $tag)
                  <a href="{{ route('user.tags.show',$tag->name) }}" class="tag-badge">
                    #{{ $tag->name }}
                  </a>
                @endforeach
              </div>
            </div>
              
         
            {{-- <div>
              <i class="far fa-heart"></i> {{ $post->likes->count() }}
            </div> --}}
            {{-- @if ($post->comments->isNotEmpty())
              <ul class="list-group mt-2">
                @foreach ($post->comments as $comment)
                  <li class="list-group-item border-0 p-0 mb-1">
                    <span class="fw-bold">{{ $comment->user->name }}</span>:
                    <span>{{ $comment->body }}</span>
                  </li>
                @endforeach
              </ul>
            @endif --}}
          </div>
        </div>
        </a>
      </div>
    @endforeach
  </div>
</div>
@endsection



{{-- CSS --}}
<style>

    body {
        background: linear-gradient(
            180deg,
            #f0f8fb 0%,
            #e6f5f8 50%,
            #ffffff 100%
        );
    }

    /* ヘッダー */
    .page-header {
      width: 100%;
      height: 440px;
      background-image: url("{{ asset('images/post-header.png') }}");
      background-size: cover;
      background-position: center;
      position: relative;
      overflow: hidden;
    }

    .page-header::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.25)
    }

    .header-text {
      position: absolute;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #ffffff;
      font-size: 42px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
      text-align: center;
      white-space: nowrap;
    }

    .add-post-btn {
      position: absolute;
      right: 24px;
      bottom: 24px;
      padding: 12px 20px;
      background:#fdbf79;
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      border-radius: 999px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      transition: all 0.2s ease;
    }

    .add-post-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
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
        transform:translateY(-6px);
        box-shadow: 0 18px 35px rgba(0, 0, 0, 0.12)
    }

    .post-card img {
        height: 220px;
        object-fit: cover;
    }

    .post-meta {
      margin-top:auto;
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

</style>
