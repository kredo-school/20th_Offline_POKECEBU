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
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('admin.hotels') }}">Hotels</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('admin.restaurants') }}">Restaurants</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('admin.customers') }}">Customers</a></li>
                <li class="nav-item mb-2"><a class="nav-link active" href="{{ route('admin.admins') }}">Admin</a></li>
            </ul>
        </div>

        <!-- メイン -->
        <div class="col-md-10 p-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Add Admin</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="John Admin">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="john@admin.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" placeholder="Super Admin">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.admins') }}" class="btn btn-outline-secondary px-4">Back</a>
                            <button type="submit" class="btn btn-success px-4">Add Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
