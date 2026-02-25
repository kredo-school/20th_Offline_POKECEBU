@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mt-3 mb-2">
        <div class="mb-1"><a href="{{ route('admin.restaurants') }}">◀︎ All Users</a></div>
        <h2>List of Restaurants</h2>
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
            @if ($restaurants)
                @foreach ($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->type === 'tmp' ? 'New' : optional($restaurant->user)->id }}</td>
                        <td>{{ $restaurant->name ?? optional($restaurant->user)->name }}</td>
                        <td>{{ $restaurant->phone }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td>{{ optional($restaurant->created_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ optional($restaurant->updated_at)->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($restaurant->status === 'approved')
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
                                    @if($restaurant->status === 'pending')
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $restaurant->id }}">
                                            <i class="fa-regular fa-circle-check"></i> Approve
                                        </button>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $restaurant->id }}">
                                            <i class="fa-regular fa-circle-xmark"></i> Reject
                                        </button>
                                    @else
                                        <a href="{{ route('admin.showDetailRestaurant', $restaurant->id) }}" class="dropdown-item">
                                            <i class="fa-solid fa-eye"></i> View details
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            @include('adminpage.list.restaurant.modals.approve')
                            @include('adminpage.list.restaurant.modals.reject')
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection