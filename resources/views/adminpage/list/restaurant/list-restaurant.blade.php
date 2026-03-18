@extends('layouts.admin')

@section('title', 'Restaurant List')

@section('content')

    <style>
        #admin-restaurant-list-root {
            --primary-blue: #4f46e5;
            --soft-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --success-green: #10b981;
            --danger-red: #ef4444;
            --pending-orange: #f59e0b;

            background-color: var(--soft-bg);
            padding: 40px 20px;
            min-height: 100vh;
            color: var(--text-dark);
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Header Style */
        #admin-restaurant-list-root .back-link {
            text-decoration: none;
            color: var(--primary-blue);
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 12px;
            transition: transform 0.2s;
        }

        #admin-restaurant-list-root .back-link:hover {
            transform: translateX(-4px);
        }

        #admin-restaurant-list-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        /* Table Card & Scroll */
        #admin-restaurant-list-root .table-section {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        #admin-restaurant-list-root .table {
            margin-bottom: 0;
            width: 100%;
            min-width: 1100px;
        }

        #admin-restaurant-list-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 18px 24px;
            white-space: nowrap;
        }

        #admin-restaurant-list-root .table tbody td {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            font-size: 0.875rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        #admin-restaurant-list-root .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        #admin-restaurant-list-root .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            gap: 5px;
        }

        #admin-restaurant-list-root .badge-approved {
            background: #ecfdf5;
            color: var(--success-green);
        }

        #admin-restaurant-list-root .badge-pending {
            background: #fffbeb;
            color: var(--pending-orange);
        }

        #admin-restaurant-list-root .badge-new {
            background: #eef2ff;
            color: var(--primary-blue);
        }

        /* Actions */
        #admin-restaurant-list-root .btn-action {
            background: transparent;
            border: none;
            color: var(--text-light);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            transition: 0.2s;
        }

        #admin-restaurant-list-root .btn-action:hover {
            background: #f1f5f9;
            color: var(--text-dark);
        }

        #admin-restaurant-list-root .dropdown-menu {
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        #admin-restaurant-list-root .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <div id="admin-restaurant-list-root">
        <div class="list-container">

            <a href="{{ route('admin.restaurants') }}" class="back-link">
                <i class="fa-solid fa-arrow-left me-2"></i> All Users
            </a>
            <h1 class="page-title">List of Restaurants</h1>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 p-3">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 p-3">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="table-section">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Restaurant Information</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Registered Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($restaurants as $restaurant)
                            <tr>
                                <td>
                                    @if ($restaurant->type === 'tmp')
                                        <span class="status-badge badge-new">New Account</span>
                                    @else
                                        <span class="fw-bold text-muted">#{{ optional($restaurant->user)->id }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $restaurant->name ?? optional($restaurant->user)->name }}</div>
                                    <div class="text-muted ms-2">({{ optional($restaurant->user)->email }})</div>
                                </td>
                                <td>{{ $restaurant->phone }}</td>
                                <td>{{ $restaurant->address }}</td>
                                <td>
                                    <span
                                        class="fw-medium">{{ optional($restaurant->created_at)->format('Y-m-d H:i') }}</span>
                                </td>
                                <td>
                                    @if ($restaurant->status === 'approved')
                                        <span class="status-badge badge-approved">
                                            <i class="fa-solid fa-circle-check"></i> Approved
                                        </span>
                                    @else
                                        <span class="status-badge badge-pending">
                                            <i class="fa-solid fa-clock"></i> Pending Review
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn-action" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow">
                                            @if ($restaurant->status === 'pending')
                                                <button class="dropdown-item text-success" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal-{{ $restaurant->id }}">
                                                    <i class="fa-regular fa-circle-check"></i> Approve
                                                </button>
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal-{{ $restaurant->id }}">
                                                    <i class="fa-regular fa-circle-xmark"></i> Reject
                                                </button>
                                            @else
                                                <a href="{{ route('admin.showDetailRestaurant', $restaurant->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fa-solid fa-eye"></i> View details
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    @include('adminpage.list.restaurant.modals.approve')
                                    @include('adminpage.list.restaurant.modals.reject')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox d-block fs-2 mb-3 opacity-25"></i>
                                    No restaurants found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
