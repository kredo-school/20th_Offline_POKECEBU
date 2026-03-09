@extends('layouts.admin')

@section('title', 'Admin Post')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-auto h2">Setting</div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-2 me-3">
                <div class="list-group">
                    <a href="{{ route('admin.category.index') }}" class="list-group-item">Categories</a>
                    <a href="{{ route('admin.category.type-index') }}" class="list-group-item">Types</a>
                    <a href="{{ route('admin.category.post-index') }}" class="list-group-item">Post</a>
                </div>
            </div>

            <div class="col-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0 text-secondary">Posts Management</h2>
                </div>

                <table class="table table-hover align-middle bg-white text-secondary border">
                    <thead class="small table-ligth text-secondary">
                        <tr class="text-center">
                            <th>#</th>
                            <th>TITLE</th>
                            <th>TAG</th>
                            <th>OWNER</th>
                            <th>CREATED AT</th>
                            <th>IMAGE</th>
                            <th>LAST UPDATED</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($all_posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td class="fw-bold text-dark">{{ $post->title }}</td>
                                <td>{{ $post->tag->name ?? 'No Tag' }}</td>
                                <td>{{ $post->user->name ?? 'Unknown User' }}</td>
                                <td>{{ now()->format('Y-m-d') }}</td>
                                <td>
                                    {{-- 画像を小さく表示 --}}
                                    @if ($post->images->isNotEmpty())
                                        <img src="{{ $post->images->first()->image }}" alt="Post Image"
                                            class="img-thumbnail" style="width:100px;">
                                    @else
                                        <img src="{{ asset('images/Icon.png') }}" alt="Default Image" class="img-thumbnail"
                                            style="width:100px;">
                                    @endif
                                </td>
                                <td>{{ optional($post->updated_at)->format('Y-m-d H:i') }}

                             
                                <td>
                                    <div >
                                            @if ($post->trashed())
                                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#unhide-post-{{ $post->id }}">
                                                    <span>Unhide Post</span>
                                                </button>
                                            @else
                                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#hide-post-{{ $post->id }}">
                                                    <span>Hide Post</span>
                                                </button>
                                            @endif
                                       
                                    </div>
                                    @include('adminpage.category.modals.post-status')

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>



            </div>


        </div>
    </div>
@endsection
