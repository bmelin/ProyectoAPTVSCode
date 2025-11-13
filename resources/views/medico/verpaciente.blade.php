@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 user-card">
            <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                <h3 class="fw-bold mb-0">Historial del Paciente</h3>
            </div>

            <div class="card-body p-4">

                {{-- ✅ Mensaje de éxito --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
                         style="background: linear-gradient(135deg, #a8e6ff 0%, #8de4ff 100%);
                                border: none; color: #004c66; font-weight: 600;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h5 class="fw-bold mb-3 text-primary">{{ $paciente->nombre }}</h5>
                <p><strong>RUT:</strong> {{ $paciente->rut }}</p>
                <p><strong>Sexo:</strong> {{ $paciente->sexo === 'F' ? 'Femenino' : 'Masculino' }}</p>

                <hr>

                <h5 class="fw-bold text-secondary mb-3">Historiales Registrados</h5>

                @if($historiales->isEmpty())
                    <p class="text-muted">No hay historiales registrados para este paciente.</p>
                @else
                    <div class="timeline-container position-relative">
    @foreach($historiales as $historial)
        <div class="timeline-item d-inline-block text-center mx-2"
            data-bs-toggle="tooltip"
            title="
                Médico: Dr.(a) {{ $historial->medico?->nombre ?? 'No registrado' }},
                Edad: {{ $historial->edad }},
                Mamografía: {{ $historial->antecedentes?->mamografia?->descripcion ?? 'No especificado' }},
                Diagnóstico previo cáncer: {{ $historial->antecedentes?->diagnosticoPrevio?->descripcion ?? 'No especificado' }},
                Familiar 1° grado: {{ $historial->familiares?->primerGrado?->descripcion ?? 'No especificado' }},
                Familiar 2° grado: {{ $historial->familiares?->segundoGrado?->descripcion ?? 'No especificado' }},
                Ejercicio: {{ $historial->habitos?->ejercicio?->descripcion ?? 'No especificado' }},
                Alcohol: {{ $historial->habitos?->alcohol?->descripcion ?? 'No especificado' }},
                Menstruación: {{ $historial->reproductivos?->menstruacion?->descripcion ?? 'No especificado' }},
                Primer hijo: {{ $historial->reproductivos?->primerHijo?->descripcion ?? 'No especificado' }},
                Riesgo cáncer:
                @if($historial->Riesgo == 0) Bajo
                @elseif($historial->Riesgo == 1) Moderado
                @elseif($historial->Riesgo == 2) Alto
                @else Desconocido @endif
            ">
            <div class="timeline-dot riesgo-{{ $historial->Riesgo }}"></div>
            <div class="timeline-date mt-2">{{ $historial->fecha_registro->format('d/m/Y') }}</div>
        </div>
    @endforeach
</div>



                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('pacientes.historial.crear', $paciente->id_paciente) }}" class="btn btn-gradient px-4 py-2 fw-semibold">
                        <i class="bi bi-plus-circle me-1"></i> Agregar nuevo historial
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tooltip con Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>

{{-- 🎨 Estilos personalizados (mismo estilo celeste del resto de vistas) --}}
<style>
.dashboard-bg {
    background: linear-gradient(160deg, #d0f0ff 0%, #b0e0ff 100%);
    min-height: 100vh;
}

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

.header-gradient {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

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

.timeline-container {
    border-top: 3px solid #00c6ff;
    padding-top: 20px;
    text-align: center;
}

.timeline-dot {
    width: 14px;
    height: 14px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 50%;
    margin: 0 auto;
    cursor: pointer;
}

.timeline-date {
    font-size: 0.9rem;
    color: #333;
}
</style>
@endsection
