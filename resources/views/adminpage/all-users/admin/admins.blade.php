@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Admin')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 text-secondary">Admins</h2>
        <a href="{{ route('admin.admin.add') }}" class="btn btn-primary fw-bolder text-white">
            <i class="fa-solid fa-plus"></i> Add Admin
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created</th>
                <th>Updated</th>
                <th style="width: 180px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ optional($admin->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ optional($admin->updated_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.admin.edit', $admin->id) }}" class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <form action="{{ route('admin.admin.delete', $admin->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this admin?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No admins found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection