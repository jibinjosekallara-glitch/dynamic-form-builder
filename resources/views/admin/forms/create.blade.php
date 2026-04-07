@extends('admin.layout')

@section('content')
<h2>Create New Form</h2>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('/admin/forms') }}">
    @csrf
    <label>Form Title:</label>
    <input type="text" name="title" placeholder="Enter form title" required>

    <label>Status:</label>
    <select name="status">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>

    <button type="submit" class="btn-add">Create Form</button>
</form>

<a href="{{ url('/admin/forms') }}" style="display:inline-block; margin-top:15px; color:#1d4ed8;">← Back to Forms</a>
@endsection