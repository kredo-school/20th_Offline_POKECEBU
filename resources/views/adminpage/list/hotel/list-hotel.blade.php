@extends('layouts.admin')

@section('title', 'Hotel List')

@section('content')

    <style>
        #admin-hotel-list-root {
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
        #admin-hotel-list-root .back-link {
            text-decoration: none;
            color: var(--primary-blue);
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 12px;
        }

        #admin-hotel-list-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 30px;
        }

        /* Table Card & Scroll */
        #admin-hotel-list-root .table-section {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            /* 横長になってもレイアウトを壊さない設定 */
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
        }

        #admin-hotel-list-root .table {
            margin-bottom: 0;
            width: 100%;
            min-width: 1100px; /* 項目を一行で維持するための最低幅 */
        }

        #admin-hotel-list-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 18px 24px;
            white-space: nowrap; /* ヘッダーも一行 */
        }

        #admin-hotel-list-root .table tbody td {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            font-size: 0.875rem;
            vertical-align: middle;
            /* ここが重要：セル内のテキストを絶対に改行させない */
            white-space: nowrap; 
        }

        #admin-hotel-list-root .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        #admin-hotel-list-root .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            gap: 5px;
        }

        #admin-hotel-list-root .badge-approved { background: #ecfdf5; color: var(--success-green); }
        #admin-hotel-list-root .badge-pending { background: #fffbeb; color: var(--pending-orange); }
        #admin-hotel-list-root .badge-new { background: #eef2ff; color: var(--primary-blue); }

        /* Actions */
        #admin-hotel-list-root .btn-action {
            background: transparent;
            border: none;
            color: var(--text-light);
            width: 32px;
            height: 32px;
            border-radius: 8px;
        }

        #admin-hotel-list-root .dropdown-menu {
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
    </style>

    <div id="admin-hotel-list-root">
        <div class="list-container">

            <a href="{{ route('admin.hotels') }}" class="back-link">
                <i class="fa-solid fa-arrow-left me-2"></i> All Users
            </a>
            <h1 class="page-title">List of Hotels</h1>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="table-section">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Hotel Information</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Registered Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hotels as $hotel)
                            <tr>
                                <td>
                                    @if($hotel->type === 'tmp')
                                        <span class="status-badge badge-new">New Account</span>
                                    @else
                                        <span class="fw-bold text-muted">#{{ optional($hotel->user)->id }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $hotel->name ?? optional($hotel->user)->name }}</div>
                                    <div class="text-muted ms-2">({{ optional($hotel->user)->email }})</div>
                                </td>
                                <td>{{ $hotel->phone }}</td>
                                <td>{{ $hotel->address }}</td>
                                <td>
                                    <span class="fw-medium">{{ optional($hotel->created_at)->format('Y-m-d H:i') }}</span>
                                </td>
                                <td>
                                    @if ($hotel->status === 'approved')
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
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if ($hotel->status === 'pending')
                                                <button class="dropdown-item text-success" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal-{{ $hotel->id }}">
                                                    <i class="fa-regular fa-circle-check"></i> Approve
                                                </button>
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal-{{ $hotel->id }}">
                                                    <i class="fa-regular fa-circle-xmark"></i> Reject
                                                </button>
                                            @else
                                                <a href="{{ route('admin.showDetailHotel', $hotel->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fa-solid fa-eye"></i> View details
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @include('adminpage.list.hotel.modals.approve')
                                    @include('adminpage.list.hotel.modals.reject')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">No hotels found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection