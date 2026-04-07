<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <a href="{{ route('admin.dashboard') }}" class="mr-4">Dashboard</a>
        <a href="{{ route('forms.index') }}" class="mr-4">Forms</a>
        <a href="{{ route('submissions.index') }}">Submissions</a>
    </nav>
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>
</body>
</html>