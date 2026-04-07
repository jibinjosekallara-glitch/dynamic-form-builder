@extends('admin.layout')

@section('content')
<h2>Edit Form</h2>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('/admin/forms/'.$form->id) }}">
    @csrf
    @method('PUT')

    <label>Form Title:</label>
    <input type="text" name="title" value="{{ $form->title }}" placeholder="Enter form title" required>

    <label>Status:</label>
    <select name="status">
        <option value="1" {{ $form->status ? 'selected' : '' }}>Active</option>
        <option value="0" {{ !$form->status ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="submit" class="btn-add">Update Form</button>
</form>

<a href="{{ url('/admin/forms') }}" style="display:inline-block; margin-top:15px; color:#1d4ed8;">← Back to Forms</a>
@endsection