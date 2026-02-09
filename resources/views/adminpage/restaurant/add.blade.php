@extends('adminpage.home')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 左メニュー省略 -->

        <div class="col-md-10 p-4">
            <h2>Add Restaurant</h2>

            <form action="{{ route('restaurant.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.restaurants') }}" class="btn btn-outline-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Add Restaurant</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
