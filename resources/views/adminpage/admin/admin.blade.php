@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css/admin.css') }}">
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
                    <a class="nav-link {{ request()->routeIs('admin.hotels') ? 'active' : '' }}" href="{{ route('admin.hotels') }}">Hotels</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.restaurants') ? 'active' : '' }}" href="{{ route('admin.restaurants') }}">Restaurants</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}">Customers</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.admins') }}">Admin</a>
                </li>
            </ul>
        </div>

        <!-- メイン -->
        <div class="col-md-10 p-4">
            <h2>Admin Table</h2>
            <a href="{{ route('admin.add') }}" class="btn btn-primary btn-sm mb-3">Add Admin</a>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Admin</td>
                        <td>john@admin.com</td>
                        <td>Super Admin</td>
                        <td>
                            <a href="{{ route('admin.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Manager</td>
                        <td>jane@admin.com</td>
                        <td>Manager</td>
                        <td>
                            <a href="{{ route('admin.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
