@extends('adminpage.home')

@section('content')
<div class="container">
    <h3>Edit Admin</h3>

    <form method="POST" action="{{ route('admin.admin.update', $admin->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ $admin->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" class="form-control" value="{{ $admin->email }}">
        </div>

        <div class="mb-3">
            <label>Password (optional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.admins') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
