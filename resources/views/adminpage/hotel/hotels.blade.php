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
                <h2>Hotels Table</h2>
                <a href="{{ route('hotel.add') }}" class="btn btn-primary btn-sm mb-3">Add Hotel</a>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="hotelTableBody">
                        <tr>
                            <td>Grand Hotel</td>
                            <td>Tokyo</td>
                            <td>03-1234-5678</td>
                            <td>
                                <a href="{{ route('hotels.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Seaside Resort</td>
                            <td>Okinawa</td>
                            <td>098-9876-5432</td>
                            <td>
                                <a href="{{ route('hotels.edit') }}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        <!-- ここに DB からホテル一覧を追加 -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

