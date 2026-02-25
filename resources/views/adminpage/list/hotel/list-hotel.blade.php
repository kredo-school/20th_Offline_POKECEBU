@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mt-3 mb-2">
        <div class="mb-1"><a href="{{ route('admin.hotels') }}">◀︎ All Users</a></div>
        <h2>List of Hotels</h2>
    </div>
    {{-- フラッシュメッセージ表示（追加） --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
    <!-- Search Area -->
    {{-- 
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">USER ID</label>
                        <div class="input-group">
                            <input type="number" name="user_id_from" class="form-control">
                            <span class="input-group-text">〜</span>
                            <input type="number" name="user_id_to" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">USER NAME</label>
                        <input type="text" name="user_name" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">PHONE NUMBER</label>
                        <input type="text" name="phone_no" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">ADDRESS</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-end mt-1">
                    <div class="col-md-4">
                        <label class="form-label small">CREATED AT</label>
                        <div class="input-group">
                            <input type="date" name="created_from" class="form-control">
                            <span class="input-group-text">〜</span>
                            <input type="date" name="created_to" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">UPDATED AT</label>
                        <div class="input-group">
                            <input type="date" name="updated_from" class="form-control">
                            <span class="input-group-text">〜</span>
                            <input type="date" name="updated_to" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small d-block">STATUS</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="" checked>
                                <label class="form-check-label">All</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Pending">
                                <label class="form-check-label">Pending</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Approval">
                                <label class="form-check-label">Approval</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Rejection">
                                <label class="form-check-label">Rejection</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    --}}

    <div class="small text-secondary mb-2">
        {{-- @if ($targetList)
            Showing {{ $targetList->firstItem() }}-{{ $targetList->lastItem() }}
            of {{ $targetList->total() }} records
        @else
            Showing 0-0 of 0 records
        @endif --}}
    </div>
    <table class="table table-hover align-middle bg-white text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th>USER ID</th>
                <th>USER NAME</th>
                <th>PHONE NUMBER</th>
                <th>ADDRESS</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($hotels)
                @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{ $hotel->type === 'tmp' ? 'New' : optional($hotel->user)->id }}</td>
                        <td>{{ $hotel->name ?? optional($hotel->user)->name }}</td>
                        <td>{{ $hotel->phone }}</td>
                        <td>{{ $hotel->address }}</td>
                        <td>{{ optional($hotel->created_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ optional($hotel->updated_at)->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($hotel->status === 'approved')
                                <i class="fa-solid fa-check text-success me-1"></i> Approved
                            @else
                                <i class="fa-solid fa-circle-exclamation text-danger me-1"></i> Pending
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if($hotel->status === 'pending')
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $hotel->id }}">
                                            <i class="fa-regular fa-circle-check"></i> Approve
                                        </button>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $hotel->id }}">
                                            <i class="fa-regular fa-circle-xmark"></i> Reject
                                        </button>
                                    @else
                                        <a href="{{ route('admin.showDetail', $hotel->id) }}" class="dropdown-item">
                                            <i class="fa-solid fa-eye"></i> View details
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            @include('adminpage.list.hotel.modals.approve')
                            @include('adminpage.list.hotel.modals.reject')
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection