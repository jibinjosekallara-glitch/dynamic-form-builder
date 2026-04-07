<!DOCTYPE html>
<html>
<head>
    <title>Available Forms</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f7fa;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .form-card {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-card h3 {
            margin: 0 0 10px;
        }

        .btn {
            padding: 6px 12px;
            background: #3490dc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #2779bd;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Available Forms</h2>

    @foreach($forms as $form)
        <div class="form-card">
            <h3>{{ $form->title }}</h3>

            <a href="{{ route('forms.show', $form->id) }}" class="btn">
                Fill Form
            </a>
        </div>
    @endforeach

</div>

</body>
</html>