@extends('layouts.admin')

@section('title', 'Post-List')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4"><i class="fa-solid fa-file-pen me-2"></i>User Posts</h3>

        <table class="table table-hover align-middle bg-white border text-secondary">
            <thead class="small table-success text-secondary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>tag</th>
                    <th>Owner</th>
                    <th>Created At</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->tag->name ?? 'No Tag' }}</td>
                        <td>{{ $post->user->name ?? 'Unknown User' }}</td>
                        <td>{{ now()->format('Y-m-d') }}</td>
                        <td>
                            <div class="card mb-0">
                                <div class="card-body p-2">
                                    <p class="mb-0 small">{{ $post->body }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{-- 画像を小さく表示 --}}
                            @if ($post->images->isNotEmpty())
                                <img src="{{ $post->images->first()->image }}" alt="Post Image" class="img-thumbnail"
                                    style="width:100px;">
                            @else
                                <img src="{{ asset('images/Icon.png') }}" alt="Default Image" class="img-thumbnail"
                                    style="width:100px;">
                            @endif

                        </td>

                        {{-- 削除ボタン系 --}}
                        <td class="td-actions">
                            <div class="dropdown">
                              <button class="action-btn-table" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                    @if ($post->trashed())
                                    <form method="POST" action="{{ route('admin.posts.activate',$post->id) }}">
                                      @csrf
                                      @method('PATCH')
                                       <button type="submit" class="dropdown-item-modern item-success"
                                            >
                                          <span>Activate Post</span>
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('admin.posts.deactivate', $post->id) }}">
                                      @csrf
                                      @method('DELETE')
                                       <button type="submit" class="dropdown-item-modern item-danger"
                                            >
                                          <span>Deactivate Post</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
