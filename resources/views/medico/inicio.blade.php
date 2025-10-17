@extends('layouts.navbarmedico')

@section('content')

<div class="dashboard-bg-medico py-5">

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
            <div class="card-body text-center p-5 text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h2 class="fw-bold">Bienvenido, Dr. {{ session('usuario')->nombre }}</h2>
                <p class="lead mb-0">Aquí puedes registrar pacientes y acceder a sus historiales.</p>
            </div>
        </div>

        <!-- Dashboard de acciones -->
        <div class="row g-4 justify-content-center">
            <!-- Registrar paciente -->
            <div class="col-md-4">
                <a href="{{ route('pacientes.crear') }}" class="text-decoration-none">
                    <div class="card shadow btn-dashboard text-center h-100 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-person-plus-fill display-4 mb-3"></i>
                            <h5 class="card-title fw-bold">Registrar Paciente</h5>
                            <p class="card-text text-muted">Agrega un nuevo paciente al sistema</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Historial de pacientes -->
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="card shadow btn-dashboard text-center h-100 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-journal-medical display-4 mb-3"></i>
                            <h5 class="card-title fw-bold">Historial de Pacientes</h5>
                            <p class="card-text text-muted">Revisa el historial y predicciones de los pacientes</p>
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

/* Fondo del dashboard médico (un poco más claro que admin) */
.dashboard-bg-medico {
    min-height: 100vh;
    background: linear-gradient(160deg, #e6f7ff 0%, #cce5ff 100%);
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
    color: #4facfe;
}

.btn-dashboard .card-title {
    color: #333;
}

.btn-dashboard .card-text {
    color: #555;
}
</style>

@endsection
