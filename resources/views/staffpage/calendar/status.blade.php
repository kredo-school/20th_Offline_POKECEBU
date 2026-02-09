@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/calendar/status.css') }}">

@endpush


@section('content')
<div class="container mt-5">
    <h3>Status for Day {{ $day }}</h3>

    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'available']) }}" class="status-box available">
        Available: {{ count($status['available']) }} rooms
    </a>

    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'in_use']) }}" class="status-box in_use">
        In-use: {{ count($status['in_use']) }} rooms
    </a>

    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'reserved']) }}" class="status-box reserved">
        Reserved: {{ count($status['reserved']) }} rooms
    </a>

    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'maintenance']) }}" class="status-box maintenance">
        Maintenance: {{ count($status['maintenance']) }} rooms
    </a>
    
    <a href="{{ route('mock.calendar', $day) }}" class="back-btn mt-3">Back</a>
</div>



@endsection
