@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Restaurant')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 text-secondary">Restaurants</h2>
        <a href="#" class="btn btn-dark fw-bolder text-white">
            <i class="fa-regular fa-address-book"></i> List of Restaurant
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
            @forelse($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->name }}</td>
                    <td>{{ $restaurant->email }}</td>
                    <td>{{ optional($restaurant->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ optional($restaurant->updated_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('restaurant.edit', $restaurant->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        <form action="{{ route('restaurant.delete', $restaurant->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this restaurant?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No restaurants found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
