@extends('layouts.navbaradmin')

@section('content')

<div class="dashboard-bg py-5">

    <div class="container-fluid px-5">

        <!-- Alerta de éxito -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- Tarjeta de bienvenida -->
        <div class="card shadow-lg mb-5 rounded-4 border-0">
            <div class="card-body text-center p-5 text-white" style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);">
                <h2 class="fw-bold">Bienvenido, Administrador {{ session('usuario')->nombre }}</h2>
                <p class="lead mb-0">Aquí puedes gestionar cuentas de médicos y administrar el sistema.</p>
            </div>
        </div>

        <!-- Dashboard de acciones -->
        <div class="row g-4 justify-content-center">
            <!-- Crear nuevo usuario -->
            <div class="col-md-4">
                <a href="{{ route('usuarios.crear') }}" class="text-decoration-none">
                    <div class="card shadow btn-dashboard text-center h-100 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-person-plus-fill display-4 mb-3"></i>
                            <h5 class="card-title fw-bold">Crear Nuevo Usuario</h5>
                            <p class="card-text text-muted">Agrega un nuevo médico al sistema</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Gestionar usuarios -->
            <div class="col-md-4">
                <a href="{{ route('usuarios.listar') }}" class="text-decoration-none">
                    <div class="card shadow btn-dashboard text-center h-100 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-people-fill display-4 mb-3"></i>
                            <h5 class="card-title fw-bold">Gestionar Usuarios</h5>
                            <p class="card-text text-muted">Editar, eliminar o revisar médicos existentes</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Estilos personalizados -->
<style>
/* Quitar márgenes y padding de body y html */
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
}

/* Fondo del dashboard */
.dashboard-bg {
    min-height: 100vh;
    background: linear-gradient(160deg, #e0f0ff 0%, #c0c0ff 100%);
}

/* Tarjetas tipo dashboard */
.btn-dashboard {
    background-color: #ffffff;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.btn-dashboard:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.25);
}

.btn-dashboard i {
    color: #007bff;
}

.btn-dashboard .card-title {
    color: #333;
}

.btn-dashboard .card-text {
    color: #555;
}
</style>

@endsection
