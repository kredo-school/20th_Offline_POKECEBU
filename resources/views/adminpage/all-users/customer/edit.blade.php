@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">

        <!-- メイン -->
        <div class="col-md-10 p-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Edit Customer</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.customer.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <small>(Leave blank to keep current)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.customers') }}" class="btn btn-outline-secondary px-4">Back</a>
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
