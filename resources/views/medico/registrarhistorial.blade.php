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
                        @php
                            $primerHistorial = $tieneHistorial ? $paciente->historiales()->first() : null; 
                            // Obtenemos el valor del primer historial del paciente
                            $primerHistorial = $paciente->historiales()->first();
                            $ultimaEdad = $paciente->historiales()->latest('fecha_registro')->first()?->edad ?? 15;
                            // Último historial
                            $primerHistorial = $paciente->historiales()->latest('fecha_registro')->first();

                            // Verificar si alguna vez respondió "Sí" en los distintos campos
                            $tuvoFamiliarPrimerGradoCC = $paciente->historiales()->where('FamiliarPrimerGradoCC', 1)->exists();
                            $tuvoFamiliarSegundoGradoCC = $paciente->historiales()->where('FamiliarSegundoGradoCC', 1)->exists();
                            $tuvoDiagnosticoPrevioCancer = $paciente->historiales()->where('DiagnosticoPrevioCancer', 1)->exists();
                        @endphp


                        <form action="{{ route('pacientes.historial.guardar', $id_paciente) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_paciente" value="{{ $id_paciente }}">
                            <input type="hidden" name="id_medico" value="{{ session('usuario')->id_usuario }}">

                            <div class="row">
                                {{-- Edad --}}
                                <div class="col-md-6 mb-3">
                                    <label for="edad" class="form-label fw-semibold">Edad</label>
                                    <input 
                                        type="number" 
                                        class="form-control rounded-3" 
                                        id="edad" 
                                        name="edad" 
                                        min="{{ $ultimaEdad }}" 
                                        placeholder="Ej: 42" 
                                        value="{{ $ultimaEdad }}" 
                                        required
                                    >
                                    @if($ultimaEdad > 15)
                                        <small class="text-muted">La edad no puede ser menor a la última registrada: {{ $ultimaEdad }} años.</small>
                                    @endif
                                </div>

                                {{-- Mamografía --}}
                                <div class="col-md-6 mb-3">
                                    <label for="mamografia" class="form-label fw-semibold">¿Mamografía en últimos 2 años?</label>
                                    <select class="form-select rounded-3" id="mamografia" name="Mamografia" required>
                                        <option value="">Selecciona</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            {{-- Antecedentes familiares --}}
                            <h5 class="fw-bold mb-3 text-primary">Antecedentes Familiares</h5>
                            <div class="row">
                                {{-- Familiares directos --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Familiares directos (madre, hermana, hija)</label>
                                    @if($tuvoFamiliarPrimerGradoCC)
                                        <select class="form-select rounded-3" name="FamiliarPrimerGradoCC_disabled" disabled>
                                            <option value="1" selected>Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                        <input type="hidden" name="FamiliarPrimerGradoCC" value="1">
                                        <small class="text-muted fst-italic">Este dato no se puede modificar porque ya fue registrado previamente.</small>
                                    @else
                                        <select class="form-select rounded-3" name="FamiliarPrimerGradoCC" required>
                                            <option value="">Selecciona</option>
                                            <option value="1">Sí</option>
                                            <option value="0" {{ $primerHistorial && $primerHistorial->FamiliarPrimerGradoCC == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                    @endif
                                </div>

                                {{-- Otros familiares --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Otros familiares (abuela, tía, prima)</label>
                                    @if($tuvoFamiliarSegundoGradoCC)
                                        <select class="form-select rounded-3" name="FamiliarSegundoGradoCC_disabled" disabled>
                                            <option value="1" selected>Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                        <input type="hidden" name="FamiliarSegundoGradoCC" value="1">
                                        <small class="text-muted fst-italic">Este dato no se puede modificar porque ya fue registrado previamente.</small>
                                    @else
                                        <select class="form-select rounded-3" name="FamiliarSegundoGradoCC" required>
                                            <option value="">Selecciona</option>
                                            <option value="1">Sí</option>
                                            <option value="0" {{ $primerHistorial && $primerHistorial->FamiliarSegundoGradoCC == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                    @endif
                                </div>

                                {{-- Diagnóstico previo de cáncer --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">¿Diagnóstico previo de cáncer?</label>
                                    @if($tuvoDiagnosticoPrevioCancer)
                                        <select class="form-select rounded-3" name="DiagnosticoPrevioCancer_disabled" disabled>
                                            <option value="1" selected>Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                        <input type="hidden" name="DiagnosticoPrevioCancer" value="1">
                                        <small class="text-muted fst-italic">Este dato no se puede modificar porque ya fue registrado previamente.</small>
                                    @else
                                        <select class="form-select rounded-3" name="DiagnosticoPrevioCancer" required>
                                            <option value="">Selecciona</option>
                                            <option value="1">Sí</option>
                                            <option value="0" {{ $primerHistorial && $primerHistorial->DiagnosticoPrevioCancer == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            {{-- Hábitos personales --}}
                            <h5 class="fw-bold mb-3 text-primary">Hábitos Personales</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Actividad física semanal</label>
                                    <select class="form-select rounded-3" name="Ejercicio" required>
                                        <option value="">Selecciona</option>
                                        <option value="nunca">Nunca</option>
                                        <option value="menos_de_3">Menos de 3 horas</option>
                                        <option value="3_a_4">De 3 a 4 horas</option>
                                        <option value="mas_de_4">Más de 4 horas</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Consumo de alcohol</label>
                                    <select class="form-select rounded-3" name="Alcohol" required>
                                        <option value="">Selecciona</option>
                                        <option value="nunca">Nunca</option>
                                        <option value="ocasional">Ocasional</option>
                                        <option value="frecuente">Frecuente</option>
                                        <option value="diario">Diario</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Edad primera menstruación</label>

                                    @if (!$tieneHistorial)
                                        {{-- Primer registro: campo editable --}}
                                        <select class="form-select rounded-3" name="Menstruacion" required>
                                            <option value="">Selecciona</option>
                                            <option value="menos_de_12">Menor a 12 años</option>
                                            <option value="12_a_13">12 a 13 años</option>
                                            <option value="mayor_de_14">Mayor a 14 años</option>
                                        </select>
                                    @else
                                        {{-- Segundo o más registros: campo bloqueado --}}
                                        <select class="form-select rounded-3" name="Menstruacion" disabled>
                                            <option value="menos_de_12" {{ $menstruacion == 'menos_de_12' ? 'selected' : '' }}>Menor a 12 años</option>
                                            <option value="12_a_13" {{ $menstruacion == '12_a_13' ? 'selected' : '' }}>12 a 13 años</option>
                                            <option value="mayor_de_14" {{ $menstruacion == 'mayor_de_14' ? 'selected' : '' }}>Mayor a 14 años</option>
                                        </select>

                                        {{-- Campo oculto para mantener el valor al enviar --}}
                                        <input type="hidden" name="Menstruacion" value="{{ $menstruacion }}">
                                        <small class="text-muted fst-italic">Este dato no se puede modificar porque ya fue registrado previamente.</small>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Edad del primer hijo/a</label>
                                    @if(!$tieneHistorial)
                                        {{-- Primer registro: todas las opciones --}}
                                        <select class="form-select rounded-3" name="PrimerHijo" required>
                                            <option value="">Selecciona</option>
                                            <option value="nunca">No ha tenido hijos</option>
                                            <option value="menor_a_30">Menor a 30 años</option>
                                            <option value="mayor_a_30">Mayor a 30 años</option>
                                        </select>
                                    @else
                                    {{-- Hay historial previo --}}
                                    @if($primerHistorial->PrimerHijo === 'nunca')
                                        {{-- Si el primer registro fue "nunca", permitir seleccionar normalmente --}}
                                        <select class="form-select rounded-3" name="PrimerHijo" required>
                                            <option value="">Selecciona</option>
                                            <option value="nunca" selected>No ha tenido hijos</option>
                                            <option value="menor_a_30">Menor a 30 años</option>
                                            <option value="mayor_a_30">Mayor a 30 años</option>
                                        </select>
                                    @else
                                    {{-- Si el primer registro fue menor_a_30 o mayor_a_30: mostrar solo la opción registrada, bloquearla y enviar valor hidden --}}
                                        <select class="form-select rounded-3" name="PrimerHijo_disabled" disabled>
                                            <option value="{{ $primerHistorial->PrimerHijo }}" selected>
                                                {{ $primerHistorial->PrimerHijo === 'menor_a_30' ? 'Menor a 30 años' : 'Mayor a 30 años' }}
                                            </option>
                                        </select>
                                   {{-- input oculto con el nombre correcto para que pase la validación --}}
                                    <input type="hidden" name="PrimerHijo" value="{{ $primerHistorial->PrimerHijo }}">
                                    <small class="text-muted fst-italic">Este dato no se puede modificar porque ya fue registrado previamente.</small>
                                    @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const edadInput = document.getElementById('edad');
    const primerHijoSelect = document.querySelector('select[name="PrimerHijo"]');
    const opcionMayor30 = primerHijoSelect.querySelector('option[value="mayor_a_30"]');

    function actualizarOpcionesHijo() {
        const edad = parseInt(edadInput.value);
        if (!isNaN(edad)) {
            if (edad < 30) {
                opcionMayor30.style.display = 'none';
                // Si estaba seleccionada, la deseleccionamos
                if (primerHijoSelect.value === 'mayor_a_30') {
                    primerHijoSelect.value = '';
                }
            } else {
                opcionMayor30.style.display = 'block';
            }
        }
    }

    // Ejecutar cuando cambie la edad
    edadInput.addEventListener('input', actualizarOpcionesHijo);
});
</script>


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
