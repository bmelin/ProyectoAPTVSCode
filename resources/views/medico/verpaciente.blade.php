@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 user-card">
            <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                <h3 class="fw-bold mb-0">Historial del Paciente</h3>
            </div>

            <div class="card-body p-4">

{{-- Riesgo de cáncer destacado --}}
@if(session('success') && session('riesgo'))
    @php
        $textoCompleto = session('success'); // "Historial registrado y riesgo calculado. Riesgo de cáncer: Alto"
        $riesgo = session('riesgo');          // "Alto"
        $textoSinRiesgo = str_replace($riesgo, '', $textoCompleto); // Quita solo el texto del riesgo
    @endphp

    <div id="riesgo-alert" class="position-fixed top-50 start-50 translate-middle shadow-lg p-5 rounded-4 text-center"
         style="z-index: 1050;
                min-width: 400px;
                max-width: 550px;
                font-size: 1.5rem;
                font-weight: 700;
                color: white;
                border: 4px solid white;
                box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                background-color: 
                    @if($riesgo === 'Bajo') #28a745
                    @elseif($riesgo === 'Moderado') #ffc107
                    @elseif($riesgo === 'Alto') #dc3545
                    @else #6c757d
                    @endif;">
        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.75rem;"></i>
        {{ $textoSinRiesgo }}
        <span style="text-decoration: underline;">{{ $riesgo }}</span>
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                onclick="document.getElementById('riesgo-alert').style.display='none';"></button>
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

@php
    $mapaRiesgo = [
        0 => 'Bajo',
        1 => 'Moderado',
        2 => 'Alto'
    ];
@endphp

<div class="timeline-container position-relative">
    @foreach($historiales as $historial)

        @php
            $riesgoInt = (int) $historial->Riesgo;
            $riesgoTexto = $mapaRiesgo[$riesgoInt] ?? 'Desconocido';

            $tooltipContent = "
                <div class='tooltip-card'>
                    <div class='tooltip-title'>Historial del " . $historial->fecha_registro->format('d/m/Y') . "</div>
                    <div class='tooltip-row'><strong>Médico:</strong> Dr.(a) ".($historial->medico->nombre ?? 'No registrado')."</div>
                    <div class='tooltip-row'><strong>Edad:</strong> {$historial->edad}</div>
                    <div class='tooltip-row'><strong>Mamografía:</strong> ".($historial->antecedentes->mamografia->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Diagnóstico previo:</strong> ".($historial->antecedentes->diagnosticoPrevio->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Familiar 1° grado:</strong> ".($historial->familiares->primerGrado->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Familiar 2° grado:</strong> ".($historial->familiares->segundoGrado->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Ejercicio:</strong> ".($historial->habitos->ejercicio->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Alcohol:</strong> ".($historial->habitos->alcohol->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Menstruación:</strong> ".($historial->reproductivos->menstruacion->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-row'><strong>Primer hijo:</strong> ".($historial->reproductivos->primerHijo->descripcion ?? 'No especificado')."</div>
                    <div class='tooltip-risk riesgo-{$riesgoInt}'>Riesgo: {$riesgoTexto}</div>
                </div>
            ";
        @endphp

        <div class="timeline-item d-inline-block text-center mx-2"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             title="{!! $tooltipContent !!}">
             
            <div class="timeline-dot riesgo-{{ $riesgoInt }}"></div>
            <div class="timeline-date mt-2">{{ $historial->fecha_registro->format('d/m/Y') }}</div>
        </div>

    @endforeach
</div>

@endif

                <div class="text-center mt-4">
                    <a href="{{ route('pacientes.historial.crear', $paciente->id_paciente) }}"
                       class="btn btn-gradient px-4 py-2 fw-semibold">
                        <i class="bi bi-plus-circle me-1"></i> Agregar nuevo historial
                    </a>
                </div>

            </div> {{-- card-body --}}
        </div>
    </div>
</div>

{{-- Tooltip Bootstrap --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el, { container: 'body' });
        });
    });
</script>

{{-- 🎨 ESTILOS COMPLETOS --}}
<style>
/* Fondo general */
.dashboard-bg {
    background: linear-gradient(160deg, #d0f0ff 0%, #b0e0ff 100%);
    min-height: 100vh;
}

/* Card con borde animado */
.user-card {    
    position: relative;
    border-radius: 1rem;
    background-color: #fff;
    color: #000;
    transition: 0.2s ease;
}

.user-card::before {
    content: "";
    position: absolute;
    inset: 0;
    padding: 2px;
    border-radius: inherit;
    background: linear-gradient(135deg, #4facfe, #00f2fe, #4facfe);
    background-size: 200% 200%;
    animation: borderMove 4s ease infinite;
    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
            mask-composite: exclude;

    pointer-events: none; /* ✅ permite clicar elementos internos */
}

@keyframes borderMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.header-gradient {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

/* Botón */
.btn-gradient {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border: none;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #3aa3f7, #00d5f0);
    color: white;
    transform: translateY(-2px);
}

/* Timeline */
.timeline-container {
    border-top: 3px solid #00c6ff;
    padding-top: 20px;
    text-align: center;
}
.timeline-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    cursor: pointer;
}
.riesgo-0 { background: #28a745; }
.riesgo-1 { background: #ffc107; }
.riesgo-2 { background: #dc3545; }

.timeline-date {
    font-size: 0.85rem;
}

/* Tooltip PRO */
.tooltip-inner {
    background: white !important;
    padding: 0 !important;
    color: black !important;
    max-width: 320px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.25);
}

.tooltip-card {
    padding: 14px;
}
.tooltip-title {
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 10px;
}
.tooltip-row {
    font-size: 13px;
    margin-bottom: 4px;
}

.tooltip-risk {
    margin-top: 10px;
    padding: 8px;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
}

.tooltip-risk.riesgo-0 {
    background: #d4edda;
    color: #155724;
}
.tooltip-risk.riesgo-1 {
    background: #fff3cd;
    color: #856404;
}
.tooltip-risk.riesgo-2 {
    background: #f8d7da;
    color: #721c24;
}
</style>

@endsection
