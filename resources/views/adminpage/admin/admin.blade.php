@extends('adminpage.home')

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- サイドバー --}}
            <div class="col-md-2 bg-light vh-100 p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.hotels') }}">Hotels</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.restaurants') }}">Restaurants</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.customer') }}">Customers</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="{{ route('admin.admins') }}">Admins</a>
                    </li>
                </ul>
            </div>

            {{-- メイン --}}



            <div class="col-md-10 p-4">
                <h2>Admin Table</h2>
                <a href="{{ route('admin.admin.add') }}" class="btn btn-primary btn-sm mb-3">Add Admin</a>





                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <a href="{{ route('admin.admin.edit', $admin->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.admin.delete', $admin->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this admin?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No admins found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
