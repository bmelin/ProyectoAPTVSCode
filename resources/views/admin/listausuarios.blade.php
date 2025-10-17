@extends('layouts.navbaradmin')

@section('content')

<div class="usuarios-bg py-5 d-flex flex-column align-items-center">

    <div class="card shadow-lg border-0 w-100" style="max-width: 1000px; border-radius: 1rem;">
        <div class="card-header d-flex justify-content-between align-items-center text-white fw-bold py-3 px-4"
             style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); border-radius: 1rem 1rem 0 0;">
            <h4 class="mb-0">Lista de Usuarios</h4>

            {{-- Botón para crear nuevo usuario --}}
            <a href="{{ route('usuarios.crear') }}" class="btn btn-add-user">
                <i class="bi bi-person-plus"></i> Agregar Usuario
            </a>
        </div>

        <div class="card-body p-4">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success text-center fw-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle text-center table-hover">
                    <thead style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($usuarios as $usuario)
                            <tr class="table-row">
                                <td>{{ $usuario->id_usuario }}</td>
                                <td class="fw-semibold">{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->correo }}</td>
                                <td>
                                    <span class="badge {{ $usuario->rol === 'admin' ? 'bg-gradient-admin' : 'bg-gradient-medico' }}">
                                        {{ ucfirst($usuario->rol) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($usuario->fecha_creacion)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('usuarios.editar', $usuario->id_usuario) }}" class="btn btn-edit btn-sm me-2">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <form action="{{ route('usuarios.eliminar', $usuario->id_usuario) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                            <i class="bi bi-trash3"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left-circle"></i> Volver al Panel
                </a>
            </div>

        </div>
    </div>

</div>

<style>
/* Fondo general */
.usuarios-bg {
    background: linear-gradient(160deg, #e0f0ff 0%, #c0c0ff 100%);
    min-height: 100vh;
    padding-top: 2rem;
    padding-bottom: 2rem;
}

/* Tarjeta principal */
.card {
    animation: fadeInUp 0.6s ease both;
    border-radius: 1rem;
}

/* Encabezado */
.card-header h4 {
    font-weight: 700;
}

/* Botón agregar usuario */
.btn-add-user {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
    font-weight: 600;
    border: none;
    border-radius: 0.5rem;
    padding: 0.5rem 1.2rem;
    transition: all 0.3s ease;
}

.btn-add-user:hover {
    background: linear-gradient(135deg, #007bff, #6610f2);
    transform: translateY(-2px);
    color: #fff;
}

/* Tabla */
.table thead th {
    vertical-align: middle;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}

.table-row:hover {
    background-color: #f2f0ff !important;
    transform: scale(1.01);
    transition: all 0.2s ease-in-out;
}

/* Badges de roles */
.bg-gradient-admin {
    background: linear-gradient(135deg, #ff6f61, #ff9671);
    color: #fff;
    font-weight: 600;
}

.bg-gradient-medico {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: #fff;
    font-weight: 600;
}

/* Botones de acción */
.btn-edit {
    background: linear-gradient(135deg, #ffc107, #ffb347);
    color: #fff;
    border: none;
    transition: transform 0.2s ease, opacity 0.3s ease;
}

.btn-edit:hover {
    transform: translateY(-2px);
    opacity: 0.9;
    color: #fff;
}

.btn-delete {
    background: linear-gradient(135deg, #e53935, #e35d5b);
    color: #fff;
    border: none;
    transition: transform 0.2s ease, opacity 0.3s ease;
}

.btn-delete:hover {
    transform: translateY(-2px);
    opacity: 0.9;
    color: #fff;
}

/* Animación general */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

@endsection
