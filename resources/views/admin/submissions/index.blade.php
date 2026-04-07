@extends('admin.layout')

@section('content')
<h2>Submissions</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<!-- 🔍 FILTER FORM -->
<form method="GET" action="{{ route('submissions.index') }}" style="margin-bottom:15px; display:flex; gap:10px; flex-wrap:wrap;">

    <!-- Form Dropdown -->
    <select name="form_id">
        <option value="">All Forms</option>
        @foreach($forms as $form)
            <option value="{{ $form->id }}" {{ request('form_id') == $form->id ? 'selected' : '' }}>
                {{ $form->title }}
            </option>
        @endforeach
    </select>

    <!-- Name -->
    <!-- <input type="text" name="name" placeholder="User Name" value="{{ request('name') }}"> -->

    <!-- Email -->
    <!-- <input type="text" name="email" placeholder="User Email" value="{{ request('email') }}"> -->

    <!-- Date -->
    <input type="date" name="date" value="{{ request('date') }}">

    <!-- Buttons -->
    <button type="submit">Filter</button>
    <a href="{{ route('submissions.index') }}" style="padding:5px 10px; background:#ccc;">Reset</a>
</form>

<!-- 📋 TABLE -->
<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Form</th>
            <!-- <th>User Name</th>
            <th>User Email</th> -->
            <th>Data</th>
            <th>Submitted At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($submissions as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->form->title ?? 'N/A' }}</td>
            <!-- <td>{{ $s->user_name }}</td>
            <td>{{ $s->user_email }}</td> -->
            <td>
                <pre>{{ json_encode(json_decode($s->data), JSON_PRETTY_PRINT) }}</pre>
            </td>
            <td>{{ $s->created_at->format('d-m-Y H:i') }}</td>
            <td>
                <form action="{{ route('submissions.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Delete this submission?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding:5px 10px; background:red; color:white; border:none; cursor:pointer;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- 📄 PAGINATION -->
<div style="margin-top:10px;">
    {{ $submissions->links() }}
</div>

@endsection