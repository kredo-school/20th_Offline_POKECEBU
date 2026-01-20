@extends('layouts.app')

@push('styles')
<style>
.menu-item { transition: background-color 0.2s ease, color 0.2s ease; }
.menu-item:hover { background-color: #f0f4ff; color: #0d6efd; }
</style>
@endpush
@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6FA9DE; height:80px;">
    <div class="container">
        <span class="navbar-brand fw-bold">My Account</span>
    </div>
</nav>
@endsection

<!DOCTYPE html>

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4">
                <div class="card-header fw-semibold">
                    Personal Information
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small">First Name</label>
                            <input type="text" class="form-control" value="{{ $user->first_name ?? '田原' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Last Name</label>
                            <input type="text" class="form-control" value="{{ $user->last_name ?? '志穏' }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label text-muted small">Email</label>
                            <input type="text" class="form-control"
                                value="{{ $user->email ?? 'shi****928@gmail.com' }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small">Phone</label>
                            <input type="text" class="form-control"
                                value="{{ $user->phonenumber ?? '070-XXXX-XXXX' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <input type="text" class="form-control" value="{{ $user->birthday ?? '誕生日' }}">
                        </div>
                    </div>


                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                            Back
                        </button>

                        <button class="btn btn-primary px-4">
                            Save
                        </button>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

@endsection