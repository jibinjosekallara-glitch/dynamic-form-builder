<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reset & base styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f6f8; color: #333; }

        /* Header */
        header {
            background-color: #1f2937;
            color: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 { font-size: 24px; }
        header nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        header nav a:hover { text-decoration: underline; }

        /* Container */
        .container {
            padding: 40px;
        }

        /* Cards (for dashboard quick links) */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 20px;
            width: 200px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .card a {
            display: block;
            margin-top: 10px;
            color: #1d4ed8;
            font-weight: bold;
            text-decoration: none;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f3f4f6;
        }
        table tr:hover { background-color: #f1f5f9; }

        /* Forms */
        form input, form select, form button {
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 12px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form button {
            background-color: #1d4ed8;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        form button:hover { background-color: #2563eb; }

        /* Alerts */
        .alert-success { background-color: #d1fae5; color: #065f46; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

<header>
    <h1>Admin Panel</h1>
    <nav>
        <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
        <a href="{{ url('/admin/forms') }}">Forms</a>
        <a href="{{ url('/admin/submissions') }}">Submissions</a>
        <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">Logout</button>
        </form>
    </nav>
</header>

<div class="container">
    @yield('content')
</div>

</body>
</html>