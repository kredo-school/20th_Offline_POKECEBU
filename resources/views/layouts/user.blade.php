@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/signup-for-company.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/detail-hotel.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/detail-restaurant.css') }}">
<link rel="stylesheet" href="{{ asset('css/user.css/hotel-serch-result.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md"
     style=" height:80px;">
    @include('layouts.partials.nav-user')
</nav>
@endsection

@section('footer')
    @include('layouts.partials.footer-user')
@endsection