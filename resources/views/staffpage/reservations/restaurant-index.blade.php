@extends('layouts.staff')

@section('title', 'Reservation List')

@section('content')

<div class="container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <h3 class="page-title">
                <i class="fa-regular fa-calendar-check"></i> Reservation List
             {{ $date->format('Y-m-d') }} </h3>
        </div>
    </div>

    <div class="card shadow-sm main-card">

        <table class="table table-bordered table-striped table-hover mb-0 text-center">

            <thead>
                <tr class="table-head table-primary text-uppercase">
                    <th>Time</th>
                    <th>Reservation ID</th>
                    <th>Guest Name</th>
                    <th>Guests</th>
                </tr>
            </thead>

            <tbody>

                @forelse($reservations as $reservation)

                <tr style="cursor:pointer"
                    onclick="window.location='{{ route('restaurant.reservations.show', $reservation->id) }}'">

                    <td>{{ $reservation->start_at->format('H:i') }}</td>
                    <td>{{ $reservation->reservation_id }}</td>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->guests }}</td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="py-4 text-muted">
                        No reservations yet
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

