@extends('layouts.admin')
 
@section('title', 'Admin All Users')
 
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-auto h2">All Users</div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-2 me-3">
                <div class="list-group">
                    <a href="{{ route('admin.customers') }}" class="list-group-item">Customers</a>
                    <a href="{{ route('admin.admins') }}" class="list-group-item">Admins</a>
                    <a href="{{ route('admin.hotels') }}" class="list-group-item">Hotels</a>
                    <a href="{{ route('admin.restaurants') }}" class="list-group-item">Restaurants</a>
                </div>
            </div>
            <div class="col-9">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
