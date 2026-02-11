@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css/mypage/edit-address.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6FA9DE; height:80px;">
    <div class="container">
        <span class="navbar-brand fw-bold">My Account</span>
    </div>
</nav>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4">
                <div class="card-header fw-semibold">
                    Address Information
                </div>

                <div class="card-body">
                    {{-- フォームの開始 📝 --}}
                    <form action="{{ route('update.adress') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-muted small">Street Address</label>
                            <input type="text" name="street_address" class="form-control"
                                value="{{ old('street_address', $user->detail->street_address ?? '') }}" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label text-muted small">City</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $user->detail->city ?? '') }}" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted small">State / Province</label>
                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $user->detail->state ?? '') }}" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted small">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ old('postal_code', $user->detail->postal_code ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Country</label>
                            <input type="text" name="country" class="form-control"
                                value="{{ old('country', $user->detail->country ?? 'Japan') }}" required>
                        </div>

                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                                Back
                            </button>

                            {{-- 保存ボタンを type="submit" に 💾 --}}
                            <button type="submit" class="btn btn-primary px-4">
                                Save
                            </button>
                        </div>
                    </form>
                    {{-- フォームの終了 --}}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection