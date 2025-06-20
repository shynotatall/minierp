<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <h1>Welcome to Mini ERP System</h1>
        <p class="lead">Manage Inventory and Sales with ease.</p>

        @if (Route::has('login'))
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-success">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
