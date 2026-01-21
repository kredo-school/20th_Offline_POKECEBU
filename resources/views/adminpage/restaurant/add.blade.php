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

            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Add Restaurant</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Restaurant Name</label>
                            <input type="text" class="form-control" placeholder="Italiano">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" placeholder="Tokyo">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="03-1111-2222">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.restaurants') }}" class="btn btn-outline-secondary px-4">Back</a>
                            <button type="submit" class="btn btn-success px-4">Add Restaurant</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
