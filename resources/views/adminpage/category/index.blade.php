@extends('layouts.admin')

@section('title', 'Admin Category')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-auto h2">Setting</div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-2 me-3">
            <div class="list-group">
                <a href="{{ route('admin.category.index') }}" class="list-group-item">Categories</a>
                <a href="{{ route('admin.category.type-index') }}" class="list-group-item">Types</a>
            </div>
        </div>
        <div class="col-9">
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
                                    <span class="text-info text-uppercase small fw-bold">
                                        <i class="fa-solid fa-hotel"></i>
                                    </span>
                                @elseif ($category->target_type === 'restaurant')
                                    <span class="text-success text-uppercase small fw-bold">
                                        <i class="fa-solid fa-utensils"></i>
                                    </span>
                                @else
                                    <span class="text-warning text-uppercase small fw-bold">
                                        <i class="fa-solid fa-hotel text-info"></i>
                                        <i class="fa-solid fa-utensils text-success"></i>
                                    </span>
                                @endif
                            </td>
                            <td>{{ optional($category->updated_at)->format('Y-m-d H:i') }}</td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection