@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Hotel')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 text-secondary">Hotels</h2>
        <a href="#" class="btn btn-dark fw-bolder text-white">
            <i class="fa-regular fa-address-book"></i> List of Hotel
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ $hotel->email }}</td>
                    <td>{{ optional($hotel->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ optional($hotel->updated_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.hotel.edit', $hotel->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this hotel?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No hotels found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
