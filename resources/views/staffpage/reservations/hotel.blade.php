@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reservation Overview</h2>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Reservation ID</th>
                <th>Guest Name</th>
                <th>Room Type</th>
                <th>Guests</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->guest->name }}</td>
                    <td>{{ $reservation->room->type }}</td>
                    <td>{{ $reservation->guests }}</td>
                    <td>{{ $reservation->date }}</td>
                    <td>
                        <span class="badge 
                            @if($reservation->status === 'Confirmed') bg-success
                            @elseif($reservation->status === 'Pending') bg-warning
                            @elseif($reservation->status === 'Cancelled') bg-danger
                            @endif">
                            {{ $reservation->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
