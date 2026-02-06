{{-- resources\views\add-for-hotel.blade.php --}}
@extends('layouts.staff')

@section('content')
<form action="{{ route('admin.hotel.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Hotel Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">City</label>
        <input type="text" class="form-control" name="city" value="{{ old('city') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.hotels') }}" class="btn btn-outline-secondary px-4">Back</a>
        <button type="submit" class="btn btn-success px-4">Save</button>
    </div>
</form>

@endsection
