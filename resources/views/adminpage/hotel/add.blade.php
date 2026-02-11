@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add Hotel</h2>
    <form action="{{ route('admin.hotel.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city') }}">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.hotels') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
