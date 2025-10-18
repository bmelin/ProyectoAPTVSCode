@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                {{-- Tarjeta del formulario --}}
                <div class="card shadow-lg border-0 rounded-4 user-card">
                    {{-- Header --}}
                    <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                        <h3 class="mb-0 fw-bold">Buscar Paciente</h3>
                    </div>

                    <div class="card-body p-4">
                        {{-- Mensaje de error --}}
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Formulario de búsqueda --}}
                        <form action="{{ route('pacientes.buscar.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rut" class="form-label fw-semibold">RUT del paciente</label>
                                <input type="text" class="form-control rounded-3" name="rut" id="rut" placeholder="Ej: 12.345.678-9" required>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-gradient px-4 py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-search me-1"></i> Buscar
                                </button>
                                <a href="{{ route('medico.dashboard') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold ms-2">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🎨 Estilos personalizados (idénticos a las otras vistas del médico) --}}
<style>
.dashboard-bg {
    background: linear-gradient(160deg, #d0f0ff 0%, #b0e0ff 100%);
    min-height: 100vh;
}

/* Tarjeta */
.user-card {
    border-radius: 1rem;
    background-color: #fff;
    color: #000;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.user-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Header con gradiente */
.header-gradient {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

/* Botones */
.btn-gradient {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: #fff;
    border: none;
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg, #3aa3f7 0%, #00d5f0 100%);
    transform: translateY(-2px);
    color: #fff;
}

.btn-outline-secondary {
    border-radius: 0.5rem;
}
</style>
@endsection
