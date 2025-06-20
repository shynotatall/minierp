<!DOCTYPE html>
<html>
<head>
    <title>Mini ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Mini ERP</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item"><span class="nav-link">{{ Auth::user()->name }} ({{ Auth::user()->role }})</span></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}"> @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @auth
        <div class="mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Products</a>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'salesperson']))
                <a href="{{ route('sales-orders.index') }}" class="btn btn-success">Sales Orders</a>
            @endif
        </div>
    @endauth

    @yield('content')
</div>
</body>
</html>
