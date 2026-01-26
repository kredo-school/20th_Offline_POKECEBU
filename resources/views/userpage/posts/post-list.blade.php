{{-- resources\views\userpage\mypage\post.blade.php --}}
@extends('layouts.user')

@section('title', 'Post-List')

@section('content')
<div class="container py-4">
    <h3 class="mb-4"><i class="fa-solid fa-file-pen me-2"></i>User Posts</h3>

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-success text-secondary">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Owner</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Content</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $index => $post)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $post['title'] }}</td>
                    <td>未設定</td>
                    <td>ユーザー名</td>
                    <td>{{ now()->format('Y-m-d') }}</td>
                    <td>下書き</td>
                    <td>
                        <div class="card mb-0">
                            <div class="card-body p-2">
                                <p class="mb-0 small">{{ $post['content'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{-- 画像を小さく表示 --}}
                        <img src="{{ asset('images/Icon.png') }}" alt="Post Image" 
                             class="img-thumbnail" style="width:100px;">
                    </td>
                    <td>
                        {{-- 編集ボタン --}}
                        <a href="{{ route('userpage.posts.edit') }}" 
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa-regular fa-pen-to-square"></i> Edit
                        </a>

                        {{-- 削除ボタン（ダミー） --}}
                        <form action="#" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection