@extends('adminpage.home')

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
                    <a class="nav-link" href="{{ route('admin.hotels') }}">Hotels</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.customers') }}">Customers</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('admin.restaurants') }}">Restaurants</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.admins') }}">Admin</a>
                </li>
            </ul>
        </div>

        <!-- メイン -->
        <div class="col-md-10 p-4">
            <h2>Restaurants Table</h2>
            <a href="{{ route('restaurant.add') }}" class="btn btn-primary btn-sm mb-3">Add Restaurant</a>

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
                    <tr>
                        <td>Italiano</td>
                        <td>Tokyo</td>
                        <td>03-1111-2222</td>
                        <td>
                            <a href="{{ route('restaurant.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sushi Place</td>
                        <td>Osaka</td>
                        <td>06-3333-4444</td>
                        <td>
                            <a href="{{ route('restaurant.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
