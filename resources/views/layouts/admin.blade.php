@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css/analysis/hotel.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css/analysis/restaurant.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css/analysis/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css/home/home.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md"
     style="background-color:#96CCB9; height:80px;">
    @include('layouts.partials.nav-admin')
</nav>
@endsection