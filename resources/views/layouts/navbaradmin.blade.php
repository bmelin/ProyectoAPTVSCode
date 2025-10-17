<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Botón Logout con gradiente y efecto hover */
        .btn-gradient {
            color: #fff;
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #0056d2 0%, #4b00b5 100%);
            transform: translateY(-2px);
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Navbar con gradiente -->
    <nav class="navbar navbar-expand-sm navbar-dark" style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);">
        <div class="container-fluid">
            <!-- Link de Inicio al panel de admin -->
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">Inicio</a>

            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-gradient btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de cada vista -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
