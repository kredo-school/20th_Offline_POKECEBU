@extends('layouts.staff')

@section('title', 'Table Overview')

@section('content')

<style>
    #table-overview-root {
        --primary-blue: #4f46e5;
        --soft-bg: #f8fafc;
        --card-border: #e2e8f0;
        --text-dark: #1e293b;
        --text-light: #64748b;
        
        background-color: var(--soft-bg);
        padding: 30px 20px;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .analysis-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--card-border);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 0;
    }

    /* Table Styles */
    .custom-table thead th {
        background: #fcfcfd;
        color: var(--text-light);
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 16px;
        border-bottom: 1px solid var(--card-border);
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: var(--text-dark);
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap; /* テーブル内は一行 */
    }

    /* Status Badges */
    .status-pill {
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .pill-available { background: #ecfdf5; color: #10b981; }
    .pill-reserved { background: #eff6ff; color: #3b82f6; }
    .pill-maintenance { background: #fff7ed; color: #f59e0b; }
    .pill-unavailable { background: #fef2f2; color: #ef4444; }

    /* Modal Reset - 親の td (text-end / nowrap) を打ち消す */
    .modal {
        white-space: normal !important;
    }
    
    .modal-content {
        border-radius: 24px;
        border: none;
        text-align: left !important; /* 強制的に左寄せ */
    }
</style>

<div id="table-overview-root">
    <div class="container-fluid">
        
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                <ul class="mb-0 small fw-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 1. Table Overview Summary --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="analysis-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="section-title"><i class="fa-solid fa-utensils me-2 text-primary"></i>Table Overview</h3>
                        <button type="button" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#createTabletypeModal">
                            <i class="fa-solid fa-plus me-1"></i> Add Table Type
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table text-center">
                            <thead>
                                <tr>
                                    <th class="text-start">Table Type</th>
                                    <th>Total</th>
                                    <th>Reserved</th>
                                    <th>Available</th>
                                    <th>Temp. Unavail.</th>
                                    <th>Unavailable</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totals = ['all'=>0, 'res'=>0, 'avail'=>0, 'tmp'=>0, 'unavail'=>0];
                                @endphp
                                @forelse ($all_table_types as $table_type)
                                    <tr>
                                        <td class="text-start fw-bold">{{ $table_type->type->name }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $table_type->total_tables }}</span></td>
                                        <td><span class="text-primary fw-bold">{{ $table_type->reserved_cnt }}</span></td>
                                        <td><span class="text-success fw-bold">{{ $table_type->available_cnt }}</span></td>
                                        <td><span class="text-warning fw-bold">{{ $table_type->tmpUnavailable_cnt }}</span></td>
                                        <td><span class="text-danger fw-bold">{{ $table_type->unavailable_cnt }}</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary border-0" data-bs-toggle="modal" data-bs-target="#updateTabletypeModal-{{ $table_type->id }}"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteTabletypeModal-{{ $table_type->id }}"><i class="fa-solid fa-trash"></i></button>
                                            
                                            {{-- インクルードするモーダル内でも modal-content に text-start を適用することを確認してください --}}
                                            @include('staffpage.tabletype.modals.tabletype-update')
                                            @include('staffpage.tabletype.modals.tabletype-delete')
                                        </td>
                                    </tr>
                                    @php
                                        $totals['all'] += $table_type->total_tables;
                                        $totals['res'] += $table_type->reserved_cnt;
                                        $totals['avail'] += $table_type->available_cnt;
                                        $totals['tmp'] += $table_type->tmpUnavailable_cnt;
                                        $totals['unavail'] += $table_type->unavailable_cnt;
                                    @endphp
                                @empty
                                    <tr><td colspan="7" class="text-muted py-4">No data available</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td class="text-start">Grand Total</td>
                                    <td>{{ $totals['all'] }}</td>
                                    <td>{{ $totals['res'] }}</td>
                                    <td>{{ $totals['avail'] }}</td>
                                    <td>{{ $totals['tmp'] }}</td>
                                    <td>{{ $totals['unavail'] }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Table Management --}}
        <div class="analysis-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title"><i class="fa-solid fa-table me-2 text-primary"></i>Table Management</h3>
                <a href="{{ route('restaurant.createTable') }}" class="btn btn-dark px-4 rounded-pill fw-bold shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Add Table
                </a>
            </div>

            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>Table No.</th>
                            <th>Type</th>
                            <th>Max Guests</th>
                            <th>Charges</th>
                            <th>Amenities</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_tables as $table)
                            <tr>
                                <td class="fw-bold text-primary">#{{ $table->table_number }}</td>
                                <td>{{ $table->type->name }}</td>
                                <td><i class="fa-solid fa-users me-1 small"></i>{{ $table->max_guests }}</td>
                                <td class="fw-bold">₱{{ number_format($table->charges) }}</td>
                                <td>
                                    @forelse ($table->categories->take(2) as $category)
                                        <span class="badge bg-light text-muted border fw-normal">{{ $category->name }}</span>
                                    @empty
                                        <span class="text-muted small">None</span>
                                    @endforelse
                                    @if($table->categories->count() > 2)
                                        <span class="text-muted small">+{{ $table->categories->count() - 2 }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [1 => 'pill-available', 2 => 'pill-reserved', 3 => 'pill-maintenance', 4 => 'pill-unavailable'];
                                        $class = $statusClasses[$table->status_id] ?? 'bg-secondary';
                                    @endphp
                                    <span class="status-pill {{ $class }}">{{ $table->status->name }}</span>
                                    <button class="btn btn-sm btn-link text-decoration-none p-0 ms-1" data-bs-toggle="modal" data-bs-target="#updateStatusModal-{{ $table->id }}">
                                        <i class="fa-solid fa-arrows-rotate small"></i>
                                    </button>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                        <a href="{{ route('restaurant.viewTable', $table->id) }}" class="btn btn-sm btn-white border border-end-0"><i class="fa-solid fa-eye"></i></a>
                                        
                                        @if ($table->status_id == 2 || $table->status_id == 3)
                                            <button class="btn btn-sm btn-white border" data-bs-toggle="modal" data-bs-target="#updateTableModal-{{ $table->id }}"><i class="fa-solid fa-pen"></i></button>
                                        @else
                                            <a href="{{ route('restaurant.editTable', $table->id) }}" class="btn btn-sm btn-white border"><i class="fa-solid fa-pen"></i></a>
                                        @endif
                                        
                                        <button class="btn btn-sm btn-white border border-start-0 text-danger" data-bs-toggle="modal" data-bs-target="#deleteTableModal-{{ $table->id }}"><i class="fa-solid fa-trash"></i></button>
                                    </div>

                                    {{-- Modals 読み込み --}}
                                    @include('staffpage.tabletype.modals.table-delete')
                                    @include('staffpage.tabletype.modals.status-update')

                                    {{-- Restricted Editing Modal (インライン定義) --}}
                                    <div class="modal fade text-start" id="updateTableModal-{{ $table->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            {{-- text-start を追加して右寄せを解除 --}}
                                            <div class="modal-content shadow-lg p-3 text-start" style="white-space: normal !important;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-lock me-2"></i>Editing Restricted</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-secondary mb-3">
                                                        This table is currently <strong>{{ $table->status->name }}</strong>. Editing is restricted to maintain reservation accuracy and prevent data conflicts.
                                                    </p>
                                                    <div class="bg-light p-3 rounded-4 mb-3 small border">
                                                        <div class="text-muted mb-1">Current Information:</div>
                                                        <strong>Table #{{ $table->table_number }}</strong> ({{ $table->type->name }})
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-secondary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Back to List</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. Create Modal --}}
        @include('staffpage.tabletype.modals.tabletype-create')
    </div>
</div>
@endsection