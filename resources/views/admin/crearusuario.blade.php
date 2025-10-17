@extends('layouts.navbaradmin')

@section('content')

<div class="dashboard-bg d-flex justify-content-center align-items-center py-5">

    <div class="card shadow-lg user-card border-0">
        <div class="card-header text-center py-3 text-white" style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); border-radius: 1rem 1rem 0 0;">
            <h4 class="fw-bold mb-0">Crear Nuevo Usuario</h4>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('usuarios.guardar') }}">
                @csrf

                <!-- Nombre -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-person-fill position-absolute input-icon"></i>
                    <input type="text" name="nombre" id="nombre" class="form-control ps-5" placeholder="Nombre completo" required>
                </div>

                <!-- Correo -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-envelope-fill position-absolute input-icon"></i>
                    <input type="email" name="correo" id="correo" class="form-control ps-5" placeholder="correo@ejemplo.com" required>
                </div>

                <!-- Contraseña -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-lock-fill position-absolute input-icon"></i>
                    <input type="password" name="contrasena" id="contrasena" class="form-control ps-5" placeholder="Contraseña" required>
                </div>

                <!-- Rol -->
                <div class="mb-4 position-relative">
                    <i class="bi bi-person-badge-fill position-absolute input-icon"></i>
                    <select name="rol" id="rol" class="form-select ps-5" required>
                        <option value="">Seleccione un rol</option>
                        <option value="medico">Médico</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-gradient w-100 py-2 fw-bold">
                    Guardar Usuario
                </button>

                <a href="{{ route('usuarios.listar') }}" class="btn btn-outline-secondary w-100 mt-3">
                    Ir a la lista
                </a>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger mt-3 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mt-3 text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

</div>

<!-- Estilos personalizados -->
<style>
.dashboard-bg {
    background: linear-gradient(160deg, #e0f0ff 0%, #c0c0ff 100%);
    min-height: 100vh;
}

/* Tarjeta del formulario */
.user-card {
    width: 100%;
    max-width: 500px;
    border-radius: 1rem;
    background-color: #fff;
    color: #000;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.user-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* Iconos dentro de inputs */
.input-icon {
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #6610f2;
    font-size: 1.1rem;
    pointer-events: none;
}

/* Inputs y selects */
.form-control, .form-select {
    height: 45px;
    border-radius: 0.5rem;
}

.form-control:focus, .form-select:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.2rem rgba(102,16,242,0.25);
}

/* Botones */
.btn-gradient {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
    color: #fff;
    border: none;
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg, #0056d2 0%, #4b00b5 100%);
    transform: translateY(-2px);
    color: #fff;
}

.btn-outline-secondary {
    border-radius: 0.5rem;
}
</style>

@endsection
