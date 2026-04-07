<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Include Admin Navigation -->
    @include('admin.nav') {{-- this is the nav file I gave you earlier --}}

    <!-- Page Content -->
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>

</body>
</html>