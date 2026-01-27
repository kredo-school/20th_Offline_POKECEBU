@extends('layouts.app')

@push('styles')
<style>
.room-card {
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
    font-size: 1.1rem;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    background: #f8f9fa; /* statusより淡めの背景 */
}

.room-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.back-btn {
    display: inline-block;
    padding: 10px 20px;
    background: #6c757d;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.2s;
}

.back-btn:hover {
    background: #5a6268;
}
</style>
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
