@extends('adminpage.home')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 左メニュー省略 -->

        <div class="col-md-10 p-4">
            <h2>Edit Restaurant</h2>

            <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $restaurant->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" value="{{ old('location', $restaurant->location) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $restaurant->phone) }}">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.restaurants') }}" class="btn btn-outline-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
