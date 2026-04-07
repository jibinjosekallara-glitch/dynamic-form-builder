@extends('admin.dashboard')

@section('content')
<h2>Forms List</h2>

<a href="{{ url('/admin/forms/create') }}" style="margin-bottom:10px; display:inline-block;">Add New Form</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    @foreach($forms as $form)
    <tr>
        <td>{{ $form->id }}</td>
        <td>{{ $form->title }}</td>
        <td>{{ $form->status ? 'Active' : 'Inactive' }}</td>
        <td>
            <a href="{{ route('forms.edit', $form->id) }}">Edit</a> |
            <a href="{{ route('admin.forms.fields', $form->id) }}" style="color:green;">Manage Fields</a>
        </td>
    </tr>
    @endforeach
</table>
@endsection