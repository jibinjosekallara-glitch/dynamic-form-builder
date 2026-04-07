@extends('admin.layout')

@section('content')
<h2>Import CSV</h2>

<!-- Back to dashboard -->
<a href="{{ url('/admin/dashboard') }}" class="btn-card" style="margin-bottom:15px; display:inline-block;">← Back to Dashboard</a>

<form action="{{ route('admin.import.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file" required>
    <button type="submit" class="btn-card" style="margin-left:10px;">Upload CSV</button>
</form>
@endsection