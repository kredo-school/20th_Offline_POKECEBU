@extends('layouts.staff')
 
@section('title', 'Table Overview')
 
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
                    <h3>Table Overview</h3>
                </div>

                <div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTabletypeModal">
                        <i class="fa-solid fa-plus"></i> Add Table Type
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle bg-white text-secondary text-center">
                        <thead class="small table-warning text-secondary">
                            <tr>
                                <th>Table Type</th>
                                <th>Total Tables</th>
                                <th>Reserved</th>
                                <th>Available</th>
                                <th>Temporarily Unavailable</th>
                                <th>Unavailable</th>
                                <th></th>
                            </tr>
                        </thead>
                        @php
                            $total = 0;
                            $total_reserved = 0;
                            $total_available = 0;
                            $total_tmpUnavailable = 0;
                            $total_unavailable = 0;
                        @endphp
                        @if (!$all_table_types->isEmpty())
                            <tbody>
                                @foreach ($all_table_types as $table_type)  
                                    <tr>
                                        <td>{{ $table_type->type->name }}</td>
                                        <td>{{ $table_type->total_tables }}</td>
                                        <td>{{ $table_type->reserved_cnt }}</td>
                                        <td>{{ $table_type->available_cnt }}</td>
                                        <td>{{ $table_type->tmpUnavailable_cnt }}</td>
                                        <td>{{ $table_type->unavailable_cnt }}</td>
                                        <td>
                                            <div class="text-end">
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateTabletypeModal-{{ $table_type->id }}"><i class="fa-solid fa-pen"></i></button>
                                                <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteTabletypeModal-{{ $table_type->id }}"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                            @include('staffpage.tabletype.modals.tabletype-update')
                                            @include('staffpage.tabletype.modals.tabletype-delete')
                                        </td>
                                    </tr>
                                        @php
                                            $total = $total + $table_type->total_tables;
                                            $total_reserved = $total_reserved + $table_type->reserved_cnt;
                                            $total_available = $total_available + $table_type->available_cnt;
                                            $total_tmpUnavailable = $total_tmpUnavailable + $table_type->tmpUnavailable_cnt;
                                            $total_unavailable = $total_unavailable + $table_type->unavailable_cnt;
                                        @endphp
                                @endforeach
                            </tbody>
                        @endif
                        <tbody class="table-secondary">
                            <tr>
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
    </div>
    <hr>
    <div class="mt-4">
        <div class="mb-3">
            <h2>Table Management</h2>
        </div>
        <div class="mb-2 text-end text-white">
                    <a href="{{ route('restaurant.createTable') }}" class="btn btn-dark">
                        <i class="fa-solid fa-plus"></i> Add Table
                    </a>
                </div>
        <table class="table table-hover align-middle bg-white text-secondary">
            <thead class="small table-secondary text-secondary">
                <th>Table Number</th>
                <th>Table Type</th>
                <th>Max Guests</th>
                <th>Charges</th>
                <th>Amenities</th>
                <th>Status</th>
                <th></th>
            </thead>
            @if (!$all_tables->isEmpty())   
                <tbody>
                    @foreach ($all_tables as $table)
                        <tr>
                            <td>{{ $table->table_number }}</td>
                            <td>{{ $table->type->name }}</td>
                            <td>{{  $table->max_guests }}</td>
                            <td>₱{{ number_format($table->charges) }}</td>
                            <td>
                                @php
                                    $categories = $table->categories;
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
                                @switch ($table->status_id)
                                    @case(1) 
                                        <div class="badge border bg-success bg-opacity-50">{{ $table->status->name }}</div>
                                        @break
                                    @case(2)
                                        <div class="badge border bg-danger bg-opacity-50">{{ $table->status->name }}</div>
                                        @break
                                    @case(3)
                                        <div class="badge border bg-warning bg-opacity-50">{{ $table->status->name }}</div>
                                        @break
                                    @case(4)
                                        <div class="badge border bg-info bg-opacity-50">{{ $table->status->name }}</div>
                                        @break
                                    @default
                                @endswitch
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#updateStatusModal-{{ $table->id }}">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </button>
                            </td>
                            <td>
                                <div class="text-end">
                                    <a href="{{ route('restaurant.viewTable', $table->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></a>
                                    
                                    @if ($table->status_id == 2 || $table->status_id == 3)
                                        <button class="btn btn-sm btn-outline-warning ms-1" data-bs-toggle="modal" data-bs-target="#updateTableModal-{{ $table->id }}"><i class="fa-solid fa-pen"></i></button>
                                    @else
                                        <a href="{{ route('restaurant.editTable', $table->id) }}" class="btn btn-sm btn-outline-warning ms-1"><i class="fa-solid fa-pen"></i></a>
                                    @endif
                                    
                                    <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteTableModal-{{ $table->id }}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                @include('staffpage.tabletype.modals.table-delete')
                                @include('staffpage.tabletype.modals.status-update')

                                <div class="modal fade" id="updateTableModal-{{ $table->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Table</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <!-- もしステータスが使用中または予約済みであれば、編集は不可 -->
                                                <p class="mb-4">
                                                    <p><strong>This table's status cannot be changed at this time.</strong></p>

                                                    Table Number: {{ $table->table_number }}<br>
                                                    Table Type: {{ $table->type->name }}<br>
                                                    Max Guests: {{ $table->max_guests }}<br>
                                                    Charges: ₱{{ number_format($table->charges) }}<br>
                                                </p>

                                                <div class="text-end">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        @include('staffpage.tabletype.modals.tabletype-create')
    </div>
</div>
@endsection
