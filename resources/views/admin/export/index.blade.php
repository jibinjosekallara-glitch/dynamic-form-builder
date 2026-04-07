@extends('admin.layout')

@section('content')
<h2>Export Data</h2>

<div class="cards">
    <div class="card">
        <h3>Users</h3>
        <a href="{{ route('admin.export.users') }}" class="btn-card">Download Users CSV</a>
    </div>
    <div class="card">
        <h3>Submissions</h3>
        <a href="{{ route('admin.export.submissions') }}" class="btn-card">Download Submissions CSV</a>
    </div>
</div>
@endsection