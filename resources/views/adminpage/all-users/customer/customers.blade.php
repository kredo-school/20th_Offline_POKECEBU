@extends('adminpage.all-users.all-users')

@section('title', 'Admin AllUsers | Customer')
@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 text-secondary">Customers</h2>
        <a href="{{ route('admin.customer.add') }}" class="btn btn-primary fw-bolder text-white">
            <i class="fa-solid fa-plus"></i> Add Customer
        </a>
    </div>
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
                <th>Created</th>
                <th>Updated</th>
                <th style="width: 180px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ optional($customer->created_at)->format('Y-m-d H:i') }}</td>
                    <td>{{ optional($customer->updated_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <form action="{{ route('admin.customer.delete', $customer->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No customers found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
