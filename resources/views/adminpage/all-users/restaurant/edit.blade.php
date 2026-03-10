@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- メイン -->
        <div class="col-md-9 p-4">
            <div class="card shadow-sm rounded-4 pt-2">
                <div class="card-header bg-light ">
                    <h5 class="mb-1">Edit Restaurant's password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.restaurant.update', $restaurant->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $restaurant->name) }}" style="background-color: lightgray;" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $restaurant->email) }}" style="background-color: lightgray;" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.restaurants') }}" class="btn btn-outline-secondary px-4">Back</a>
                            <button type="submit" class="btn btn-warning px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- エラーメッセージを表示するコード --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
