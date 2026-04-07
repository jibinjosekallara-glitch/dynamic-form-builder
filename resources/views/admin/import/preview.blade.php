@extends('admin.layout')

@section('content')
<h2>Preview CSV Import</h2>

<form action="{{ route('admin.import.confirm') }}" method="POST">
    @csrf
    <table class="table">
        <thead>
            <tr>
                @foreach($header as $h)
                    <th>{{ ucfirst($h) }}</th>
                @endforeach
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preview as $row)
            <tr style="background-color: {{ $row['valid'] ? '#d1fae5' : '#fee2e2' }};">
                @foreach($header as $h)
                    <td>{{ $row[$h] }}</td>
                @endforeach
                <td>{{ $row['valid'] ? 'Valid' : 'Invalid' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn-card" style="margin-top:15px;">Confirm Import Valid Rows</button>
</form>
@endsection