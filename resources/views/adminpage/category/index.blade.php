@extends('layouts.admin')

@section('title', 'Admin Categories')

@section('content')
    {{-- 使う時にindexとmodalsの中にあるstatusのコメントを外して --}}
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Add a category">
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary fw-bolder text-white" data-bs-toggle="modal"
                            data-bs-target="#add-category">
                            <i class="fa-solid fa-plus"></i> Add New Category
                        </button>
                        @include('adminpage.category.modals.add')
                    </div>
                </div>
            </form>

            <table class="table table-hover align-middle bg-white text-secondary border">
                <thead class="small table-warning text-secondary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th>TYPE</th>
                        <th>LAST UPDATED</th>
                        <th></th>
                    </tr>
                </thead>
                {{-- <tbody class="text-center">
                    @foreach ($all_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->categoryRoom->count() }}</td>
                            <td>{{ $category->type }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#edit-category-{{ $category->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm ms-1" data-bs-toggle="modal"
                                        data-bs-target="#delete-category-{{ $category->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                </button>
                                
                                @include('adminpage.category.modals.status')
                            </td>
                        </tr>
                    @endforeach --}}
                <tr>
                    <td></td>
                    <td>
                        Uncategorized <br>
                        <small class="col-desc text-muted">Hidden posts are not included.</small>
                    </td>
                    {{-- <td>{{ $uncategorized }}</td> --}}
                    <td colspan="2"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
