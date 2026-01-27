@extends('layouts.app')

@push('styles')
<style>
.status-box {
    display: block;
    padding: 25px;
    border-radius: 12px;
    color: #fff;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
    font-size: 1.1rem;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.status-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.available { background: linear-gradient(135deg,#28a745,#85e085);}      /* green */
.in_use { background: linear-gradient(135deg,#17a2b8,#63d2d9);}        /* cyan */
.reserved { background: linear-gradient(135deg,#007bff,#66b2ff);}      /* blue */
.maintenance { background: linear-gradient(135deg,#ffc107,#ffe066); color:#000;} /* yellow */

.back-btn {
    display: inline-block;
    padding: 10px 20px;
    background: #6c757d;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.2s;
}
</style>
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
