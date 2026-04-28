<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body { height: 100%; }
        body {
            margin: 0;
            background: url('{{ asset("images/login-hero.png") }}') center center / cover no-repeat;
            background-attachment: fixed;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans';
        }
        .auth-wrapper { min-height: 100vh; }
        .login-panel { width: 420px; margin-right: 40px; }
        @media (max-width: 767.98px) { .login-panel { width: auto; margin: 20px; } }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-end auth-wrapper">
        <div class="login-panel">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
