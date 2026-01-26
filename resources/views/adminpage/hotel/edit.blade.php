@extends('layouts.admin')
@section('title', 'Edit Hotel')

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
                    <a class="nav-link active" href="{{ route('admin.hotels') }}">Hotels</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.customers') }}">Customers</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.restaurants') }}">Restaurants</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.admins') }}">Admin</a>
                </li>
            </ul>
        </div>

        <!-- 右側（mypage風 edit） -->
        <div class="col-md-10 p-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="card shadow-sm rounded-4">
                        <div class="card-header fw-semibold">
                            Edit Hotel
                        </div>

                        <div class="card-body">

                            <!-- Hotel Image -->
                            <div class="text-center mb-4">
                                <img src="https://via.placeholder.com/100"
                                     class="rounded mb-2"
                                     alt="Hotel Image">
                                <div class="small text-muted">
                                    Hotel photo (edit later)
                                </div>
                            </div>

                            <form>
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Hotel Name</label>
                                    <input type="text" class="form-control" value="Grand Hotel">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small">Location</label>
                                    <input type="text" class="form-control" value="Tokyo">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small">Phone</label>
                                    <input type="text" class="form-control" value="03-1234-5678">
                                </div>

                                <div class="d-flex justify-content-end mt-4 gap-2">
                                    <a href="{{ route('admin.hotels') }}"
                                       class="btn btn-outline-secondary px-4">
                                        Back
                                    </a>

                                    <button class="btn btn-primary px-4">
                                        Save
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
