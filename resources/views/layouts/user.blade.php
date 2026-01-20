@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css/user.css') }}">
@endpush

@section('navbar')
<nav class="navbar navbar-expand-md shadow-sm"
     style="background-color:#6FA9DE; height:80px;">
    @include('layouts.partials.nav-user')
</nav>
@endsection