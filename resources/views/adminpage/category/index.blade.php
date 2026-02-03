@extends('layouts.admin')

@section('title', 'Admin Categories')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10"> {{-- 幅を少し広げました --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0 text-secondary">Category Management</h2>
                <button type="button" class="btn btn-primary fw-bolder text-white" data-bs-toggle="modal"
                    data-bs-target="#add-category">
                    <i class="fa-solid fa-plus"></i> Add New Category
                </button>
            </div>

            @include('adminpage.category.modals.add')

            <table class="table table-hover align-middle bg-white text-secondary border">
                <thead class="small table-light text-secondary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th>TYPE</th>
                        <th>LAST UPDATED</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($all_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="fw-bold text-dark">{{ $category->name }}</td>

                            <td>
                                @if ($category->target_type === 'hotel')
                                    <span>{{ $category->categoryRooms->count() }}</span>
                                @else
                                    <span>{{ $category->categoryTables->count() }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($category->target_type === 'hotel')
                                    <span class="text-info text-uppercase small fw-bold">
                                        <i class="fa-solid fa-hotel"></i>
                                    </span>
                                @else
                                    <span class="text-success text-uppercase small fw-bold">
                                        <i class="fa-solid fa-utensils"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#edit-category-{{ $category->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm ms-1" data-bs-toggle="modal"
                                    data-bs-target="#delete-category-{{ $category->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                {{-- Edit & Delete Modals (IDごとに生成) --}}
                                @include('adminpage.category.modals.edit')
                                @include('adminpage.category.modals.delete')
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No categories found.</td>
                        </tr>
                    @endforelse

                    <tr class="table-light">
                        {{-- Hotel Uncategorized --}}
                        <td colspan="2" class="text-start ps-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Uncategorized Rooms</strong><br>
                                    <small class="text-muted">No assigned category.</small>
                                </div>
                            </div>
                        </td>
                        <td class="border-end">
                            <span class="fw-bold text-danger fs-5 pe-3">{{ $uncategorized_rooms }}</span>
                        </td>

                        {{-- Restaurant Uncategorized --}}
                        <td colspan="2" class="text-start ps-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Uncategorized Tables</strong><br>
                                    <small class="text-muted">No assigned category.</small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="fw-bold text-danger fs-5 pe-3">{{ $uncategorized_tables }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
