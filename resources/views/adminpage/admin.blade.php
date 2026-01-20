@extends('adminpage.admin-home')

@section('admin-content')
<h2>Admins</h2>

<table class="table table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Super Admin</td>
            <td>admin@example.com</td>
            <td>Super</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Staff Admin</td>
            <td>staff@example.com</td>
            <td>Staff</td>
        </tr>
    </tbody>
</table>
@endsection
