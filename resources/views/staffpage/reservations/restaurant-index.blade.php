@extends('layouts.staff')

@section('title', 'Reservation List')

@section('content')

    <div class="container  mt-4">

        <a href="{{ route('restaurant.calendar') }}" class="btnbtn-sm mt-4 text-decoration-none text-dark">
            <i class="fa-solid fa-arrow-left"></i> calendar
        </a>

        {{-- Header --}}
        <div class="table-wrapper">

            <a href="{{ route('restaurant.reservations.date', $date->copy()->subDay()->format('Y-m-d')) }}" class="nav-day prev">
                <i class="fa-solid fa-chevron-left"></i>
            </a>

            <a href="{{ route('restaurant.reservations.date', $date->copy()->addDay()->format('Y-m-d')) }}" class="nav-day next">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">
                            <i class="fa-regular fa-calendar-check"></i>
                            Reservation List: <span class="fw-bold">{{ $date->format('Y/m/d') }}</span>
                        </h3>
                    </div>
                </div>
                <div class="row justify-content-center text-center m-4">

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Tables</h6>
                                <h3>
                                    {{ $totalTables }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Guests</h6>
                                <h3>
                                    {{ $totalGuests }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">

            <table class="table table-bordered table-hover mb-0 text-center">

                <thead>
                    <tr class="table-head table-primary text-uppercase">
                        <th>Time</th>
                        <th>Reservation ID</th>
                        <th>Guest Name</th>
                        <th>Guests</th>
                        <th>Room</th>
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
                            <td>{{ $reservation->table->type->name }}</td>

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



<style>
    .table-wrapper {
        position: relative;
    }

    .nav-day {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: white;
        border: 1px solid #ddd;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        z-index: 1;
    }

    .nav-day:hover {
        background: #f8f9fa;
        transform: translateY(-50%) scale(1.05);
    }

    .prev {
        left: -25px;
    }

    .next {
        right: -25px;
    }
</style>
@endsection

