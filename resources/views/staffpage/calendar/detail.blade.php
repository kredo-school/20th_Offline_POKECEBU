@extends('layouts.app')

@push('styles')
{{-- <<link rel="stylesheet" href="{{ asset('css/staff.css/calendar/detail.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/staff.css/calendar/detail.css') }}">
@endpush

@section('content')
<div class="container mt-5">
    <h3>{{ ucfirst($type) }} Rooms for Day {{ $day }}</h3>

    <div class="mt-3">
        @foreach($roomList as $room)
            <div class="room-card">
                Room {{ $room }}
            </div>
        @endforeach
    </div>

    <a href="{{ route('mock.calendar', $day) }}" class="back-btn mt-3">Back</a>
</div>
@endsection
