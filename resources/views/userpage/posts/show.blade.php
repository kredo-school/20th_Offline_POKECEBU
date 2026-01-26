{{-- resources\views\userpage\posts\show.blade.php --}}
@extends('layouts.user')

@section('title', 'Show Post')

@section('content')
<div class="container py-4">
  @php
    $posts = [
      (object)[
        'id' => 1,
        'image' => asset('images/pokecebuicon.png'),
        'description' => 'これはダミーの投稿です',
        'created_at' => now(),
        'user' => (object)['id' => 1, 'name' => 'ユーザー名1', 'avatar' => null],
        'likes' => collect([1, 2, 3]),
        'categoryPost' => [(object)['category' => (object)['name' => 'Food']]],
        'comments' => collect([
          (object)[
            'id' => 1,
            'body' => 'コメント1です',
            'created_at' => now(),
            'user' => (object)['id' => 1, 'name' => 'コメントユーザー1']
          ]
        ]),
      ],
      (object)[
        'id' => 2,
        'image' => asset('images/pokecebuicon.png') ,
        'description' => 'ビュー確認用の投稿です',
        'created_at' => now(),
        'user' => (object)['id' => 2, 'name' => 'ユーザー名2', 'avatar' => null],
        'likes' => collect([1]),
        'categoryPost' => [(object)['category' => (object)['name' => 'Travel']]],
        'comments' => collect([]),
      ],
      (object)[
        'id' => 3,
        'image' => asset('images/pokecebuicon.png'),
        'description' => '追加したダミー投稿その1です',
        'created_at' => now(),
        'user' => (object)['id' => 3, 'name' => 'ユーザー名3', 'avatar' => null],
        'likes' => collect([1,2]),
        'categoryPost' => [(object)['category' => (object)['name' => 'Culture']]],
        'comments' => collect([]),
      ],
      (object)[
        'id' => 4,
        'image' => asset('images/Icon.png'),
        'description' => '追加したダミー投稿その2です',
        'created_at' => now(),
        'user' => (object)['id' => 4, 'name' => 'ユーザー名4', 'avatar' => null],
        'likes' => collect([]),
        'categoryPost' => [],
        'comments' => collect([]),
      ],
    ];
  @endphp

  <div class="row">
    @foreach ($posts as $post)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
          <img src="{{ $post->image }}" alt="Post Image" class="card-img-top img-fluid">
          <div class="card-body">
            <h5 class="card-title">{{ $post->user->name }}</h5>
            <p class="card-text">{{ $post->description }}</p>
            <p class="text-muted small">{{ $post->created_at->format('M d, Y') }}</p>
            <div class="mb-2">
              @foreach ($post->categoryPost as $category_post)
                <span class="badge bg-secondary">{{ $category_post->category->name }}</span>
              @endforeach
              @if (empty($post->categoryPost))
                <span class="badge bg-dark">Uncategorized</span>
              @endif
            </div>
            <div>
              <i class="far fa-heart"></i> {{ $post->likes->count() }}
            </div>
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
    @endforeach
  </div>
</div>
@endsection