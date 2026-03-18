@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Hotel')

@section('admin-content')

    <style>
        #admin-hotel-user-root {
            --primary-blue: #4f46e5;
            --soft-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --danger-red: #ef4444;
            --warning-amber: #f59e0b;
            --dark-slate: #334155;
            
            background-color: var(--soft-bg);
            padding: 20px 0;
            color: var(--text-dark);
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Header Style */
        #admin-hotel-user-root .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        #admin-hotel-user-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Table Card & Scroll */
        #admin-hotel-user-root .table-section {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
        }

        #admin-hotel-user-root .table {
            margin-bottom: 0;
            width: 100%;
            min-width: 900px; 
        }

        #admin-hotel-user-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 18px 24px;
            white-space: nowrap;
        }

        #admin-hotel-user-root .table tbody td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            font-size: 0.875rem;
            vertical-align: middle;
            white-space: nowrap; 
        }

        #admin-hotel-user-root .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Avatar / Icon Placeholder */
        #admin-hotel-user-root .hotel-icon {
            width: 32px;
            height: 32px;
            background: #f1f5f9;
            color: var(--dark-slate);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        /* Buttons */
        #admin-hotel-user-root .btn-list {
            background-color: var(--dark-slate);
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.875rem;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        #admin-hotel-user-root .btn-list:hover {
            background-color: #1e293b;
            transform: translateY(-2px);
            color: white;
        }

        #admin-hotel-user-root .btn-edit {
            color: var(--warning-amber);
            background: #fffbeb;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
            text-decoration: none;
            margin-right: 4px;
        }

        #admin-hotel-user-root .btn-delete {
            color: var(--danger-red);
            background: #fff1f2;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        #admin-hotel-user-root .btn-edit:hover { background: var(--warning-amber); color: white; }
        #admin-hotel-user-root .btn-delete:hover { background: var(--danger-red); color: white; }

        #admin-hotel-user-root .custom-alert {
            border-radius: 12px;
            border: none;
            padding: 16px;
            font-weight: 500;
        }
    </style>

    <div id="admin-hotel-user-root">
        {{-- Header Section --}}
        <div class="header-section">
            <h1 class="page-title">Hotel Partners</h1>
            <a href="{{ route('admin.showList', 'hotel') }}" class="btn-list">
                <i class="fa-regular fa-address-book me-2"></i> List of Hotels
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm custom-alert mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Table Section --}}
        <div class="table-section">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Hotel User</th>
                        <th>Email Address</th>
                        <th>Last Updated</th>
                        <th>Created Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hotels as $hotel)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hotel-icon">
                                        <i class="fa-solid fa-hotel"></i>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $hotel->name }}</div>
                                </div>
                            </td>
                            <td><span class="text-muted">{{ $hotel->email }}</span></td>
                            <td>
                                <div class="small fw-medium">{{ optional($hotel->updated_at)->format('Y-m-d') }}</div>
                                <div class="small text-muted">{{ optional($hotel->updated_at)->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">{{ optional($hotel->created_at)->format('Y-m-d') }}</div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.hotel.edit', $hotel->id) }}" class="btn-edit text-decoration-none">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.hotel.delete', $hotel->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" onclick="return confirm('Delete hotel user \'{{ $hotel->name }}\'? This will remove their access.')">
                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-building-circle-exclamation d-block fs-1 mb-3 opacity-25"></i>
                                No hotels found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection