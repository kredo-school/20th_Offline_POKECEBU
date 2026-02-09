@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css/mypage/edit-personal.css') }}">
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
                        Personal Informationjjjj
                    </div>

                    <div class="card-body">
                        {{-- エラーメッセージ表示エリア --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3" style="color: red; border: 1px solid red; padding: 10px;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('mypage.updateProfile') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label text-muted small">Firstnn Name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ old('first_name', $user->detail->first_name ?? '') }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ old('last_name', $user->detail->last_name ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label text-muted small">Email</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label text-muted small">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->detail->phone ?? '') }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-muted small">Date of Birth</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ old('birthday', isset($user->detail->birthday) ? \Carbon\Carbon::parse($user->detail->birthday)->format('Y-m-d') : '') }}">
                                </div>
                            </div> {{-- ここでrowを閉じる --}}

                            <div class="d-flex justify-content-end mt-4 gap-2">
                                <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                                    Back
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
