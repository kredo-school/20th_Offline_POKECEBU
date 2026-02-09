@extends('adminpage.home')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-2 bg-light vh-100 p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.hotels') ? 'active' : '' }}" 
                       href="{{ route('admin.hotels') }}">
                        Hotels
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.restaurants') ? 'active' : '' }}" 
                       href="{{ route('admin.restaurants') }}">
                        Restaurants
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}" 
                       href="{{ route('admin.customer') }}">
                        Customers
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.admins') ? 'active' : '' }}" 
                       href="{{ route('admin.admins') }}">
                        Admin
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <h2>Restaurants Table</h2>
            <a href="{{ route('restaurant.add') }}" class="btn btn-primary btn-sm mb-3">Add Restaurant</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->name }}</td>
                            <td>{{ $restaurant->location }}</td>
                            <td>{{ $restaurant->phone }}</td>
                            <td>
                                <a href="{{ route('restaurant.edit', $restaurant->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('restaurant.delete', $restaurant->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this restaurant?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
