@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endpush

@section('navbar')
    <nav class="navbar navbar-expand-md shadow-sm" style="background-color:#96CCB9; height:80px;">
        @include('layouts.partials.nav-admin')
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- 左サイドメニュー -->
            <div class="col-md-2 bg-light vh-100 p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('admin.hotels') ? 'active' : '' }}"
                            href="{{ route('admin.hotels') }}">Hotels</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('admin.restaurants') ? 'active' : '' }}"
                            href="{{ route('admin.restaurants') }}">Restaurants</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}"
                            href="{{ route('admin.customers') }}">Customers</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('admin.admins') ? 'active' : '' }}"
                            href="{{ route('admin.admins') }}">Admin</a>
                    </li>
                </ul>
            </div>

            <!-- 右側 -->
            <div class="col-md-10 p-4">
                <h2>Customers Table</h2>
              <a href="{{ route('customers.add') }}" class="btn btn-primary btn-sm">Add customers</a>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="customerTableBody">
                        <tr>
                            <td>John Smith</td>
                            <td>john@example.com</td>
                            <td>090-1234-5678</td>
                            <td>
                                <a href="{{ route('customers.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jane Doe</td>
                            <td>jane@example.com</td>
                            <td>080-9876-5432</td>
                            <td>
                                 <a href="{{ route('customers.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
