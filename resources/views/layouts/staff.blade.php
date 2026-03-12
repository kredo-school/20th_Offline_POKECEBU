@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/staff.css') }}">
<link rel="stylesheet" href="{{ asset('css/staff.css/add-for-hotel.css') }}">
<link rel="stylesheet" href="{{ asset('css/staff.css/analysis/hotel.css') }}">
<link rel="stylesheet" href="{{ asset('css/staff.css/analysis/restaurant.css') }}">

@endpush

@section('navbar')
<nav class="navbar navbar-expand-md"
     style="background-color:#6FA9DE; height:80px;">
    @include('layouts.partials.nav-staff')
</nav>
@endsection