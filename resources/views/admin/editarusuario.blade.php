@extends('layouts.navbaradmin')

@section('content')

<div class="editar-bg d-flex justify-content-center align-items-center py-5">

    <div class="card shadow-lg border-0 w-100" style="max-width: 600px; border-radius: 1rem;">
        <div class="card-header text-center text-white py-3"
             style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); border-radius: 1rem 1rem 0 0;">
            <h4 class="fw-bold mb-0">Editar Usuario</h4>
        </div>

        <div class="card-body p-4">
            {{-- Mensaje de éxito o error --}}
            @if (session('success'))
                <div class="alert alert-success text-center fw-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.actualizar', $usuario->id_usuario) }}" method="POST">
                @csrf
                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control input-style" id="nombre" name="nombre"
                           value="{{ $usuario->nombre }}" required>
                </div>

                {{-- Correo --}}
                <div class="mb-3">
                    <label for="correo" class="form-label fw-semibold">Correo</label>
                    <input type="email" class="form-control input-style" id="correo" name="correo"
                           value="{{ $usuario->correo }}" required>
                </div>

                {{-- Contraseña --}}
                <div class="mb-3">
                    <label for="contrasena" class="form-label fw-semibold">Contraseña (opcional)</label>
                    <input type="password" class="form-control input-style" id="contrasena" name="contrasena"
                           placeholder="Dejar vacío para no cambiar">
                </div>

                {{-- Rol --}}
                <div class="mb-4">
                    <label for="rol" class="form-label fw-semibold">Rol</label>
                    <select class="form-select input-style" id="rol" name="rol" required>
                        <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="medico" {{ $usuario->rol === 'medico' ? 'selected' : '' }}>Médico</option>
                    </select>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('usuarios.listar') }}" class="btn btn-secondary px-4">
                        <i class="bi bi-arrow-left-circle"></i> Volver
                    </a>

                    <button type="submit" class="btn btn-gradient px-4 fw-bold">
                        <i class="bi bi-check-circle"></i> Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
/* Fondo general */
.editar-bg {
    background: linear-gradient(160deg, #e0f0ff 0%, #c0c0ff 100%);
    min-height: 100vh;
}

/* Estilo de inputs */
.input-style {
    border-radius: 0.5rem;
    height: 45px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}

.input-style:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.2);
}

/* Botón gradiente */
.btn-gradient {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg, #0056d2 0%, #4b00b5 100%);
    transform: translateY(-2px);
    color: #fff;
}

/* Animación */
.card {
    animation: fadeInUp 0.6s ease both;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

@endsection
