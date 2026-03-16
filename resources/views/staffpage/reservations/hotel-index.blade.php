@extends('layouts.staff')

@section('title', 'Reservation List')

@section('content')

    <div class="container">

        {{-- Header --}}

        <div class="card shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="mb-1">
                        <i class="fa-regular fa-calendar-check"></i>
                        Reservation: <span class="fw-bold">{{ $date->format('Y/m/d') }}</span>
                    </h3>
                </div>
            </div>
            <div class="row text-center m-4">

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Total Guests</h6>
                            <h3>{{ $totalGuests }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Rooms</h6>
                            <h3>{{ $totalRooms }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Chech In</h6>
                            <h3>{{ $checkins }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Check Out</h6>
                            <h3>{{ $checkouts }}</h3>
                        </div>
                    </div>
                </div>

            </div>

        </div>




        <div class="card shadow-sm">

            <table class="table table-bordered table-hover mb-0 text-center">

                <thead>
                    <tr class="table-primary">
                        <th>Status</th>
                        <th>Reservation ID</th>
                        <th>Guest Name</th>
                        <th>Guests</th>
                        <th>Room</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($reservations as $reservation)
                        <tr style="cursor:pointer"
                            onclick="window.location='{{ route('hotel.reservations.show', $reservation->id) }}'">

                            <td>
                                @if ($reservation->start_at->isSameDay($date))
                                    <span class="text-primary">Check In</span>
                                @elseif($reservation->end_at->isSameDay($date))
                                    <span class="text-danger">Check Out</span>
                                @else
                                    <span>Stay</span>
                                @endif
                            </td>
                            <td>{{ $reservation->reservation_id }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->guests }}</td>
                            <td>{{ $reservation->room->type->name }}</td>

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
        <a href="#" class="btn btn-outline-secondary btn-sm mt-4">
                      <i class="fa-solid fa-arrow-left"></i> Back
                  </a>
    </div>

@endsection
