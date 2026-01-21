@extends('layouts.staff')

@section('title', 'Edit Restaurant')

@section('content')
    <!-- Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h2 class="mb-4">Edit Restaurant</h2>

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <form action="" method="post">
                            @csrf
                            @method('PATCH')
                            <!-- Restaurant name -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Table type <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control">
                            </div>

                            <!-- Total tables -->
                            <div class="mb-4">
                                <label class="form-label">
                                    Total seats <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control">
                            </div>

                            <!-- Buttons -->
                            <button class="btn btn-primary w-100 mb-3">
                                Edit
                            </button>

                            <a href="#" class="btn btn-outline-primary w-100">
                                Cancel
                            </a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
