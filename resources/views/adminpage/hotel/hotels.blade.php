@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 左サイドメニュー -->
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

        <!-- メインコンテンツ -->
     <div class="col-md-10 p-4">
            <h2 class="mt-3">Hotels</h2>

            <a href="{{ route('admin.hotel.add') }}" class="btn btn-primary mb-3">Add Hotel</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->city }}</td>
                            <td>{{ $hotel->phone }}</td>
                            <td>{{ $hotel->address }}</td>
                            <td>
                                <a href="{{ route('admin.hotel.edit', $hotel->id) }}" 
                                   class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST" 
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Delete this hotel?')">
                                        Delete
                                    </button>
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
