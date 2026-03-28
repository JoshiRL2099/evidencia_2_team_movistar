<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="/">Sistema</a>

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                Dashboard
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-light">
                Órdenes
            </a>

            <a href="{{ route('users.index') }}" class="btn btn-outline-light">
                Usuarios
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                Productos
            </a>

            <a href="{{ route('orders.trash') }}" class="btn btn-outline-light">
                Papelera
            </a>

            <a href="{{ route('logout') }}" class="btn btn-outline-light"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>