@extends('layouts.staff')
 
@section('title', 'Room Overview')
 
@section('content')
    
 
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center mb-4">
        <div class="card col-7">
            <div class="card-body">
                <div class="mb-2">
                    <h3>Rooms Overview</h3>
                </div>

                <div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomtypeModal">
                        <i class="fa-solid fa-plus"></i> Add Room Type
                    </button>
                </div>

                <table class="table align-middle bg-white text-secondary">
                    <thead class="small table-warning text-secondary">
                        <tr>
                            <th>#</th>
                            <th>Room Type</th>
                            <th>Total Rooms</th>
                            <th>Reserved</th>
                            <th>Available</th>
                            <th>Temporarily Unavailable</th>
                            <th>Unavailable</th>
                            <th></th>
                        </tr>
                    </thead>
                    @if (!$all_room_types->isEmpty())
                        @php
                            $total = 0;
                            $total_reserved = 0;
                            $total_available = 0;
                            $total_tmpUnavailable = 0;
                            $total_unavailable = 0;
                        @endphp
                        <tbody>
                            @foreach ($all_room_types as $room_type)  
                                <tr>
                                    <td>{{ $room_type->id }}</td>
                                    <td>{{ $room_type->type->name }}</td>
                                    <td>{{ $room_type->total_rooms }}</td>
                                    <td>{{ $room_type->reserved_cnt }}</td>
                                    <td>{{ $room_type->available_cnt }}</td>
                                    <td>{{ $room_type->tmpUnavailable_cnt }}</td>
                                    <td>{{ $room_type->unavailable_cnt }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateRoomtypeModal-{{ $room_type->id }}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteRoomtypeModal-{{ $room_type->id }}"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                        @include('staffpage.roomtype.modals.roomtype-update')
                                        @include('staffpage.roomtype.modals.roomtype-delete')
                                    </td>
                                </tr>
                                    @php
                                        $total = $total + $room_type->total_rooms;
                                        $total_reserved = $total_reserved + $room_type->reserved_cnt;
                                        $total_available = $total_available + $room_type->available_cnt;
                                        $total_tmpUnavailable = $total_tmpUnavailable + $room_type->tmpUnavailable_cnt;
                                        $total_unavailable = $total_unavailable + $room_type->unavailable_cnt;
                                    @endphp
                            @endforeach
                        </tbody>
                    @endif
                    <tbody class="table-secondary">
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td>{{ $total }}</td>
                            <td>{{ $total_reserved }}</td>
                            <td>{{ $total_available }}</td>
                            <td>{{ $total_tmpUnavailable }}</td>
                            <td>{{ $total_unavailable }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-4">
        <div class="mb-3">
            <h2>Room Management</h2>
        </div>
        <div class="mb-2 text-end text-white">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createRoomModal-">
                        <i class="fa-solid fa-plus"></i> Add Room
                    </button>
                </div>
        <table class="table table-hover align-middle bg-white text-secondary">
            <thead class="small table-secondary text-secondary">
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Floor Number</th>
                <th>Max Guests</th>
                <th>Charges</th>
                <th>Amenities</th>
                <th>Status</th>
                <th></th>
            </thead>
            @if (!$all_rooms->isEmpty())   
                <tbody>
                    @foreach ($all_rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->type->name }}</td>
                            <td>{{ $room->floor_number }}</td>
                            <td>{{  $room->max_guests }}</td>
                            <td>¥{{ number_format($room->charges)  }}</td>
                            <td>
                                @php
                                    $categories = $room->categories;
                                @endphp
                                @if ($categories->isEmpty())
                                    <span class="text-muted small">No amenity</span>
                                @else
                                    @foreach ($categories->take(3) as $category)
                                        <div class="badge border bg-white bg-opacity-50 text-dark mb-1">
                                            {{ $category->name }}
                                        </div>
                                    @endforeach
                                    @if ($categories->count() > 3)
                                        <span class="badge bg-secondary bg-opacity-50 text-dark">
                                            etc
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td >
                                <div class="badge border bg-success bg-opacity-50">{{ $room->status->name }}</div>
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#updateStatusModal-{{ $room->id }}">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </button>
                            </td>
                            <td>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateRoomModal-{{ $room->id }}"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteRoomModal-{{ $room->id }}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                @include('staffpage.roomtype.modals.room-update')
                                @include('staffpage.roomtype.modals.room-delete')
                                @include('staffpage.roomtype.modals.status-update')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        @include('staffpage.roomtype.modals.room-create')
        @include('staffpage.roomtype.modals.roomtype-create')
    </div>
</div>
@endsection
