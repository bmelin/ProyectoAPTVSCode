<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Médico</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Navbar con gradiente azul claro */
        .navbar-gradient {
            background: linear-gradient(160deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Botón Logout con mismo gradiente de la navbar */
        .btn-navbar-gradient {
            color: #fff;
            background: linear-gradient(160deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-navbar-gradient:hover {
            background: linear-gradient(160deg, #3aa3f7 0%, #00d5f0 100%);
            transform: translateY(-2px);
            color: #fff;
        }

        .navbar-brand {
            color: #fff;
        }
        .navbar-brand:hover {
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Navbar con gradiente -->
    <nav class="navbar navbar-expand-sm navbar-dark navbar-gradient">
        <div class="container-fluid">
            <!-- Link de Inicio al panel médico -->
            <a class="navbar-brand fw-bold" href="{{ route('medico.dashboard') }}">Inicio</a>

            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-navbar-gradient btn-sm">
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
