@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-lg border-0 rounded-4 user-card">
                    <div class="card-header text-white bg-primary rounded-top-4">
                        <h4 class="mb-0 text-center">Registrar Historial Médico</h4>
                    </div>

                    <div class="card-body px-4 py-4">
                        <form action="{{ route('pacientes.historial.guardar', $id_paciente) }}" method="POST">
                            @csrf

                            {{-- Edad --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Edad</label>
                                <input type="number" name="edad" class="form-control" required value="{{ old('edad', $edad) }}">
                            </div>

                            {{-- Mamografía --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">¿Se ha realizado mamografía?</label>
                                <select name="id_mamografia" class="form-select" required>
                                    <option value="">Seleccione</option>
                                    @foreach($respuestas as $r)
                                        <option value="{{ $r->id_respuesta }}">{{ $r->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Diagnóstico previo de cáncer --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">¿Ha tenido diagnóstico previo de cáncer?</label>
                                <select name="id_diagnostico_previo" class="form-select" required>
                                    <option value="">Seleccione</option>
                                    @foreach($respuestas as $r)
                                        <option value="{{ $r->id_respuesta }}">{{ $r->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Familiares 1° y 2° grado --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Familiar de 1° grado con cáncer</label>
                                    <select name="id_familiar_primer_grado" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($respuestas as $r)
                                            <option value="{{ $r->id_respuesta }}">{{ $r->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Familiar de 2° grado con cáncer</label>
                                    <select name="id_familiar_segundo_grado" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($respuestas as $r)
                                            <option value="{{ $r->id_respuesta }}">{{ $r->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Hábitos --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ejercicio físico</label>
                                    <select name="id_ejercicio" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($opcionesEjercicio as $op)
                                            <option value="{{ $op->id_ejercicio }}">{{ ucfirst(str_replace('_', ' ', $op->id_ejercicio)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Consumo de alcohol</label>
                                    <select name="id_alcohol" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($opcionesAlcohol as $op)
                                            <option value="{{ $op->id_alcohol }}">{{ ucfirst(str_replace('_', ' ', $op->id_alcohol)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Factores reproductivos --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Edad de la primera menstruación</label>
                                    <select name="id_menstruacion" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($opcionesMenstruacion as $op)
                                            <option value="{{ $op->id_menstruacion }}">{{ ucfirst(str_replace('_', ' ', $op->id_menstruacion)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Edad del primer hijo</label>
                                    <select name="id_primer_hijo" class="form-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach($opcionesPrimerHijo as $op)
                                            <option value="{{ $op->id_primer_hijo }}">{{ ucfirst(str_replace('_', ' ', $op->id_primer_hijo)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4">Registrar historial</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
