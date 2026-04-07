@extends('admin.layout')

@section('content')
<h2>Manage Fields for Form: {{ $form->title }}</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<h3>Add New Field</h3>
<form method="POST" action="{{ route('admin.forms.fields.store', $form->id) }}">
    @csrf
    <div>
        <label>Label:</label>
        <input type="text" name="label" required>
    </div>
    <div>
        <label>Type:</label>
        <select name="type" required>
            <option value="text">Text</option>
            <option value="textarea">Textarea</option>
            <option value="number">Number</option>
            <option value="email">Email</option>
            <option value="date">Date</option>
            <option value="dropdown">Dropdown</option>
            <option value="checkbox">Checkbox</option>
        </select>
    </div>
    <div>
        <label>Required:</label>
        <select name="required">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
    <div>
        <label>Validation (optional):</label>
        <input type="text" name="validation">
    </div>
    <div>
        <label>Options (for dropdown/checkbox, comma separated):</label>
        <input type="text" name="options">
    </div>
    <div>
        <label>Order:</label>
        <input type="number" name="order" value="0">
    </div>
    <button type="submit">Add Field</button>
</form>

<h3>Existing Fields</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Label</th>
        <th>Type</th>
        <th>Required</th>
        <th>Validation</th>
        <th>Options</th>
        <th>Order</th>
    </tr>
    @foreach($fields as $field)
    <tr>
        <td>{{ $field->id }}</td>
        <td>{{ $field->label }}</td>
        <td>{{ $field->type }}</td>
        <td>{{ $field->required ? 'Yes' : 'No' }}</td>
        <td>{{ $field->validation }}</td>
        <td>{{ $field->options }}</td>
        <td>{{ $field->order }}</td>
    </tr>
    @endforeach
</table>
@endsection