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

<body>
   <!-- Content Here --> 
    
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4">
                <div class="card-header fw-semibold">
                    Address Information
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Street Address</label>
                        <input type="text" class="form-control"
                            value="{{ $user->street_address ?? 'じゅうしょ' }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label text-muted small">City</label>
                            <input type="text" class="form-control"
                                value="{{ $user->city ?? 'City' }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted small">State / Province</label>
                            <input type="text" class="form-control"
                                value="{{ $user->state ?? 'State' }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted small">Postal Code</label>
                            <input type="text" class="form-control"
                                value="{{ $user->postal_code ?? '000-0000' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Country</label>
                        <input type="text" class="form-control"
                            value="{{ $user->country ?? 'Japan' }}">
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button"
                            class="btn btn-outline-secondary px-4"
                            onclick="history.back()">
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