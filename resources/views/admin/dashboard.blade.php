@extends('admin.layout')

@section('content')
<h2>Welcome, {{ auth()->user()->name }}</h2>

<div class="cards">
    <div class="card">
        <h3>Forms</h3>
        <a href="{{ url('/admin/forms') }}" class="btn-card">Manage Forms</a>
    </div>
    <div class="card">
        <h3>Submissions</h3>
        <a href="{{ url('/admin/submissions') }}" class="btn-card">View Submissions</a>
    </div>
    <div class="card">
        <h3>Users</h3>
        <a href="{{ url('/admin/users') }}" class="btn-card">Manage Users</a>
    </div>
    <div class="card">
        <h3>Import</h3>
        <a href="{{ url('/admin/import') }}" class="btn-card">Import CSV</a>
    </div>
    <div class="card">
        <h3>Export</h3>
        <a href="{{ url('/admin/export') }}" class="btn-card">Export CSV</a>
    </div>
</div>
@endsection

@push('styles')
<style>
.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.card {
    flex: 1 1 200px;
    background-color: #f3f4f6;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.card h3 {
    margin-bottom: 15px;
    color: #1d4ed8;
}

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