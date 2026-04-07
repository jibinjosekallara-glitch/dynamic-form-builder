<!DOCTYPE html>
<html>
<head>
    <title>{{ $form->title }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }

        .checkbox-group {
            margin-bottom: 15px;
        }

        button {
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #45a049;
        }

        .submissions {
            margin-top: 30px;
        }

        .submission-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .submission-card strong {
            color: #333;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>{{ $form->title }}</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="form-box">
        @if ($errors->any())
    <div style="background:#ffe6e6; padding:10px; margin-bottom:15px;">
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('forms.submit', $form->id) }}" method="POST">
            @csrf

            @foreach($form->fields as $field)

                @php
                    if (is_string($field->options)) {
                        $options = json_decode($field->options) ?: [];
                    } elseif (is_array($field->options)) {
                        $options = $field->options;
                    } else {
                        $options = [];
                    }
                    $fieldName = $field->name ?? 'field_'.$field->id;
                @endphp

                <label>{{ $field->label }}</label>

                @if(in_array($field->type, ['text','email','number']))
                    <input type="{{ $field->type }}" name="{{ $fieldName }}">
                
                @elseif($field->type === 'textarea')
                    <textarea name="{{ $fieldName }}"></textarea>

                @elseif($field->type === 'dropdown')
                    <select name="{{ $fieldName }}">
                        @foreach($options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>

                @elseif($field->type === 'checkbox')
                    <div class="checkbox-group">
                        @foreach($options as $option)
                            <label>
                                <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $option }}">
                                {{ $option }}
                            </label>
                        @endforeach
                    </div>
                @endif

            @endforeach

            <button type="submit">Submit</button>
        </form>
    </div>

    {{-- Submissions --}}
    @if(isset($submissions) && $submissions->count())
        <div class="submissions">
            <h3>Previous Submissions</h3>

            @foreach($submissions as $submission)
                <div class="submission-card">

                    @php
                        $data = is_array($submission->data) 
                            ? $submission->data 
                            : json_decode($submission->data, true);
                    @endphp

                    @foreach($form->fields as $field)
                        @php
                            $fieldName = $field->name ?? 'field_'.$field->id;
                            $value = $data[$fieldName] ?? null;
                        @endphp

                        @if($value)
                            <strong>{{ $field->label }}:</strong>

                            @if(is_array($value))
                                {{ implode(', ', $value) }}
                            @else
                                {{ $value }}
                            @endif

                            <br>
                        @endif
                    @endforeach

                </div>
            @endforeach
                   
        </div>
        
    @endif
 <div style="margin-top:10px;">
   @if($submissions->total())
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">

        <!-- Previous / Next -->
        <div>
            @if ($submissions->onFirstPage())
                <span>« Previous</span>
            @else
                <a href="{{ $submissions->previousPageUrl() }}">« Previous</a>
            @endif

            |

            @if ($submissions->hasMorePages())
                <a href="{{ $submissions->nextPageUrl() }}">Next »</a>
            @else
                <span>Next »</span>
            @endif
        </div>

        <!-- Showing count -->
        <div>
            Showing {{ $submissions->firstItem() }} 
            to {{ $submissions->lastItem() }} 
            of {{ $submissions->total() }} results
        </div>

    </div>
@endif
</div>
</div>


</body>
</html>