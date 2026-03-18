@extends('layouts.admin')

@section('title', 'Admin Category Settings')

@section('content')

    <style>
        #admin-settings-root {
            --primary-blue: #4f46e5;
            --soft-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --danger-red: #ef4444;
            --warning-amber: #f59e0b;
            --success-green: #10b981;
            
            background-color: var(--soft-bg);
            padding: 40px 20px;
            min-height: 100vh;
            color: var(--text-dark);
            font-family: 'Inter', system-ui, sans-serif;
        }

        #admin-settings-root .settings-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        #admin-settings-root .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Sidebar Navigation */
        #admin-settings-root .settings-nav {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            padding: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        #admin-settings-root .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 600;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        #admin-settings-root .nav-item:last-child { margin-bottom: 0; }

        #admin-settings-root .nav-item:hover {
            background: var(--soft-bg);
            color: var(--primary-blue);
        }

        #admin-settings-root .nav-item.active {
            background: #eef2ff;
            color: var(--primary-blue);
        }

        /* Main Content Card */
        #admin-settings-root .content-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid var(--card-border);
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        #admin-settings-root .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        /* Table Style */
        #admin-settings-root .table-wrapper {
            overflow-x: auto;
        }

        #admin-settings-root .table thead th {
            background: #fcfcfd;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 16px 20px;
            white-space: nowrap;
        }

        #admin-settings-root .table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Type Icons */
        #admin-settings-root .type-badge {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        /* Buttons */
        #admin-settings-root .btn-add {
            background: var(--primary-blue);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
            transition: 0.2s;
        }

        #admin-settings-root .btn-add:hover {
            transform: translateY(-2px);
            background: #4338ca;
            color: #ffffff;
        }

        #admin-settings-root .btn-action-outline {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--card-border);
            background: transparent;
            transition: 0.2s;
        }

        #admin-settings-root .btn-edit:hover { border-color: var(--warning-amber); color: var(--warning-amber); }
        #admin-settings-root .btn-delete:hover { border-color: var(--danger-red); color: var(--danger-red); }
    </style>

    <div id="admin-settings-root">
        <div class="settings-container">
            <h1 class="page-title">System Settings</h1>

            <div class="row g-4">
                {{-- Left Side: Navigation --}}
                <div class="col-lg-3">
                    <nav class="settings-nav">
                        <a href="{{ route('admin.category.index') }}" class="nav-item active">
                            <i class="fa-solid fa-layer-group me-3"></i> Categories
                        </a>
                        <a href="{{ route('admin.category.type-index') }}" class="nav-item">
                            <i class="fa-solid fa-tags me-3"></i> Types
                        </a>
                        <a href="{{ route('admin.category.post-index') }}" class="nav-item">
                            <i class="fa-solid fa-signs-post me-3"></i> Post Settings
                        </a>
                    </nav>
                </div>

                {{-- Right Side: Content --}}
                <div class="col-lg-9">
                    <div class="content-card">
                        <div class="card-header-flex">
                            <h2 class="h5 fw-extrabold mb-0">Category Management</h2>
                            <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#add-category">
                                <i class="fa-solid fa-plus me-2"></i> New Category
                            </button>
                        </div>

                        @include('adminpage.category.modals.add')

                        <div class="table-wrapper">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="80">ID</th>
                                        <th>Category Name</th>
                                        <th class="text-center">Target Type</th>
                                        <th>Last Updated</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($all_categories as $category)
                                        <tr>
                                            <td class="text-center text-muted fw-bold">#{{ $category->id }}</td>
                                            <td>
                                                <span class="fw-bold text-dark">{{ $category->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($category->target_type === 'hotel')
                                                    <div class="type-badge bg-info bg-opacity-10 text-info" title="Hotel">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                @elseif ($category->target_type === 'restaurant')
                                                    <div class="type-badge bg-success bg-opacity-10 text-success" title="Restaurant">
                                                        <i class="fa-solid fa-utensils"></i>
                                                    </div>
                                                @else
                                                    <div class="type-badge bg-warning bg-opacity-10 text-warning" title="Both">
                                                        <i class="fa-solid fa-circle-nodes"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small fw-medium">{{ optional($category->updated_at)->format('Y-m-d') }}</div>
                                                <div class="small text-muted">{{ optional($category->updated_at)->format('H:i') }}</div>
                                            </td>
                                            <td class="text-end">
                                                <button class="btn-action-outline btn-edit me-1" data-bs-toggle="modal"
                                                    data-bs-target="#edit-category-{{ $category->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button class="btn-action-outline btn-delete" data-bs-toggle="modal"
                                                    data-bs-target="#delete-category-{{ $category->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>

                                                @include('adminpage.category.modals.edit')
                                                @include('adminpage.category.modals.delete')
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                No categories found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection