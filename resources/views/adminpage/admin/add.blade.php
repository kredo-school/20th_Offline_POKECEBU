@extends('adminpage.home')

@section('content')
<div class="container">
    <h3>Add Admin</h3>

    <form method="POST" action="{{ route('admin.admin.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.admins') }}" class="btn btn-secondary">Back</a>
        {{-- エラーメッセージを表示するコード --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.admin.store') }}">
    ...
    </form>
</div>
@endsection
