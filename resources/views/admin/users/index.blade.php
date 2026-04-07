@extends('admin.layout')

@section('content')
<h2>All Users</h2>

<!-- Back to dashboard button -->
<a href="{{ url('/admin/dashboard') }}" class="btn-card" style="margin-bottom:15px; display:inline-block;">← Back to Dashboard</a>

<!-- Users Table -->
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ $user->created_at->format('d M, Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div style="margin-top:15px;">
    {{ $users->links() }}
</div>
@endsection

@push('styles')
<style>
/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.table th {
    background-color: #1d4ed8;
    color: #fff;
}

.table tr:nth-child(even) {
    background-color: #f3f4f6;
}

.table tr:hover {
    background-color: #e0e7ff;
}

/* Button styling */
.btn-card {
    display: inline-block;
    padding: 10px 20px;
    background-color: #1d4ed8;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.2s ease;
}

.btn-card:hover {
    background-color: #2563eb;
}
</style>
@endpush