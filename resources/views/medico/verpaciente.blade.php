@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 user-card">
            <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                <h3 class="fw-bold mb-0">Historial del Paciente</h3>
            </div>

            <div class="card-body p-4">
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
                                 Edad: {{ $historial->edad }},
                                 Mamografía: {{ $historial->Mamografia ? 'Sí' : 'No' }},
                                 Ejercicio: {{ $historial->Ejercicio }},
                                 Alcohol: {{ $historial->Alcohol }},
                                 Menstruación: {{ $historial->Menstruacion }},
                                 Primer hijo: {{ $historial->PrimerHijo }}">
                                <div class="timeline-dot"></div>
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

<style>
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
