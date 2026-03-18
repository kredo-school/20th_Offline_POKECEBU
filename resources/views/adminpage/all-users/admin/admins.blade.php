@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Admin')

@section('admin-content')

    <style>
        #admin-list-root {
            --primary-blue: #4f46e5;
            --soft-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --danger-red: #ef4444;
            --warning-amber: #f59e0b;
            
            background-color: var(--soft-bg);
            padding: 20px 0;
            color: var(--text-dark);
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Header Style */
        #admin-list-root .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        #admin-list-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Table Card & Scroll */
        #admin-list-root .table-section {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
        }

        #admin-list-root .table {
            margin-bottom: 0;
            width: 100%;
            min-width: 900px; 
        }

        #admin-list-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 18px 24px;
            white-space: nowrap;
        }

        #admin-list-root .table tbody td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            font-size: 0.875rem;
            vertical-align: middle;
            white-space: nowrap; 
        }

        #admin-list-root .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Avatar Placeholder */
        #admin-list-root .admin-avatar {
            width: 32px;
            height: 32px;
            background: #eef2ff;
            color: var(--primary-blue);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }

        /* Buttons */
        #admin-list-root .btn-add {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.875rem;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }

        #admin-list-root .btn-add:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            color: white;
        }

        #admin-list-root .btn-edit {
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

        #admin-list-root .btn-delete {
            color: var(--danger-red);
            background: #fff1f2;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        #admin-list-root .btn-edit:hover { background: var(--warning-amber); color: white; }
        #admin-list-root .btn-delete:hover { background: var(--danger-red); color: white; }

        #admin-list-root .custom-alert {
            border-radius: 12px;
            border: none;
            padding: 16px;
            font-weight: 500;
        }
    </style>

    <div id="admin-list-root">
        {{-- Header Section --}}
        <div class="header-section">
            <h1 class="page-title">Administrator Access</h1>
            <a href="{{ route('admin.admin.add') }}" class="btn-add text-decoration-none">
                <i class="fa-solid fa-user-plus me-2"></i> Add New Admin
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
                        <th>Administrator</th>
                        <th>Email Address</th>
                        <th>Last Updated</th>
                        <th>Created Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="admin-avatar">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-dark">{{ $admin->name }}</div>
                                </div>
                            </td>
                            <td><span class="text-muted">{{ $admin->email }}</span></td>
                            <td>
                                <div class="small fw-medium">{{ optional($admin->updated_at)->format('Y-m-d') }}</div>
                                <div class="small text-muted">{{ optional($admin->updated_at)->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">{{ optional($admin->created_at)->format('Y-m-d') }}</div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.admin.edit', $admin->id) }}" class="btn-edit">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.admin.delete', $admin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" onclick="return confirm('Delete admin \'{{ $admin->name }}\'? This action cannot be undone.')">
                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-user-shield d-block fs-1 mb-3 opacity-25"></i>
                                No administrators found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection