@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Tarjeta del formulario --}}
                <div class="card shadow-lg border-0 rounded-4 user-card">
                    {{-- Header --}}
                    <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                        <h3 class="mb-0 fw-bold">Registro de Historial del Paciente</h3>
                    </div>

                    <div class="card-body p-4">
                        {{-- Mensajes de error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pacientes.historial.guardar', $id_paciente) }}" method="POST">
                            @csrf

                            {{-- Edad --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edad" class="form-label fw-semibold">Edad (calculada automáticamente)</label>
                                    <input type="number" name="edad" class="form-control rounded-3" value="{{ $edad }}" readonly>
                                </div>


                                {{-- Mamografía --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">¿Mamografía en últimos 2 años?</label>
                                    <select name="id_mamografia" class="form-select rounded-3" required>
                                        <option value="">Selecciona</option>
                                        @foreach($respuestas as $r)
                                            <option value="{{ $r->id_respuesta }}">{{ ucfirst($r->descripcion) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            {{-- Diagnóstico previo y familiares --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">¿Diagnóstico previo de cáncer?</label>
    <select name="id_diagnostico_previo" class="form-select rounded-3" required
        @if($antecedentes['id_diagnostico_previo'] == 1) disabled @endif>
        <option value="">Selecciona</option>
        @foreach($respuestas as $r)
            <option value="{{ $r->id_respuesta }}"
                {{ $antecedentes['id_diagnostico_previo'] == $r->id_respuesta ? 'selected' : '' }}>
                {{ ucfirst($r->descripcion) }}
            </option>
        @endforeach
    </select>

    @if($antecedentes['id_diagnostico_previo'] == 1)
        <input type="hidden" name="id_diagnostico_previo" value="1">
    @endif
</div>


                                <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Familiar de 1° grado con cáncer</label>
    <select name="id_familiar_primer_grado" class="form-select rounded-3" required
        @if($antecedentes['id_familiar_primer_grado'] == 1) disabled @endif>
        <option value="">Selecciona</option>
        @foreach($respuestas as $r)
            <option value="{{ $r->id_respuesta }}"
                {{ $antecedentes['id_familiar_primer_grado'] == $r->id_respuesta ? 'selected' : '' }}>
                {{ ucfirst($r->descripcion) }}
            </option>
        @endforeach
    </select>

    @if($antecedentes['id_familiar_primer_grado'] == 1)
        <input type="hidden" name="id_familiar_primer_grado" value="1">
    @endif
</div>


                                <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">Familiar de 2° grado con cáncer</label>
    <select name="id_familiar_segundo_grado" class="form-select rounded-3" required
        @if($antecedentes['id_familiar_segundo_grado'] == 1) disabled @endif>
        <option value="">Selecciona</option>
        @foreach($respuestas as $r)
            <option value="{{ $r->id_respuesta }}"
                {{ $antecedentes['id_familiar_segundo_grado'] == $r->id_respuesta ? 'selected' : '' }}>
                {{ ucfirst($r->descripcion) }}
            </option>
        @endforeach
    </select>

    @if($antecedentes['id_familiar_segundo_grado'] == 1)
        <input type="hidden" name="id_familiar_segundo_grado" value="1">
    @endif
</div>

                            </div>

                            <hr>

                            {{-- Hábitos personales --}}
                            <h5 class="fw-bold mb-3 text-primary">Hábitos Personales</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Actividad física semanal</label>
                                    <select name="id_ejercicio" class="form-select rounded-3" required>
                                        <option value="">Selecciona</option>
                                        @foreach($opcionesEjercicio as $op)
                                            <option value="{{ $op->id_ejercicio }}">
                                                {{ ucfirst(str_replace('_', ' ', $op->descripcion ?? $op->id_ejercicio)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Consumo de alcohol</label>
                                    <select name="id_alcohol" class="form-select rounded-3" required>
                                        <option value="">Selecciona</option>
                                        @foreach($opcionesAlcohol as $op)
                                            <option value="{{ $op->id_alcohol }}">
                                                {{ ucfirst(str_replace('_', ' ', $op->descripcion ?? $op->id_alcohol)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            {{-- Factores reproductivos --}}
                            <h5 class="fw-bold mb-3 text-primary">Factores Reproductivos</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
    <label class="form-label">Edad de la primera menstruación</label>

    {{-- Si NO existe historial previo → campo editable --}}
    @if (!$tieneHistorial)
        <select name="id_menstruacion" class="form-select rounded-3" required>
            <option value="">Selecciona</option>
            @foreach($opcionesMenstruacion as $op)
                <option value="{{ $op->id_menstruacion }}">
                    {{ ucfirst(str_replace('_', ' ', $op->descripcion)) }}
                </option>
            @endforeach
        </select>

    {{-- Si YA existe un historial → bloquear selección pero mantener el valor --}}
    @else
        <select class="form-select rounded-3" disabled>
            @foreach($opcionesMenstruacion as $op)
                <option value="{{ $op->id_menstruacion }}"
                    {{ $menstruacion == $op->id_menstruacion ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $op->descripcion)) }}
                </option>
            @endforeach
        </select>

        {{-- Enviar valor igual que antes --}}
        <input type="hidden" name="id_menstruacion" value="{{ $menstruacion }}">
    @endif
</div>


                                <div class="col-md-6 mb-3">
    <label class="form-label">Edad del primer hijo/a</label>

    @php
        $ID_NUNCA = 'nunca';
    @endphp

    {{-- Si ya tuvo un hijo alguna vez (valor distinto de "nunca") → campo bloqueado --}}
    @if($primerHijo && $primerHijo !== $ID_NUNCA)

        <select class="form-select rounded-3" disabled>
            @foreach($opcionesPrimerHijo as $op)
                <option value="{{ $op->id_primer_hijo }}"
                    {{ $primerHijo == $op->id_primer_hijo ? 'selected' : '' }}>
                    {{ $op->descripcion }}
                </option>
            @endforeach
        </select>

        <input type="hidden" name="id_primer_hijo" value="{{ $primerHijo }}">

    @else

        {{-- Campo editable --}}
        <select name="id_primer_hijo" class="form-select rounded-3" required>
            <option value="">Selecciona</option>

            @foreach($opcionesPrimerHijo as $op)
                <option value="{{ $op->id_primer_hijo }}"
                    {{ old('id_primer_hijo') == $op->id_primer_hijo ? 'selected' : '' }}>
                    {{ $op->descripcion }}
                </option>
            @endforeach

        </select>

    @endif
</div>




                            </div>

                            {{-- Botones --}}
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-gradient px-4 py-2 rounded-3 shadow-sm fw-semibold">
                                    <i class="bi bi-save2 me-1"></i> Guardar Historial
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

{{-- Estilos personalizados --}}
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
