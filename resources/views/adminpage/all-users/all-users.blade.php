@extends('layouts.admin')
 
@section('title', 'Admin All Users')
 
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center" style="margin-top: 50px;">
            <div class="col-2 mt-4 me-3">
                
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
