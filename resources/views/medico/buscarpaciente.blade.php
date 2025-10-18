@extends('layouts.navbarmedico')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 user-card">
                    <div class="card-header text-white text-center py-3 header-gradient rounded-top">
                        <h3 class="mb-0 fw-bold">Buscar Paciente</h3>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('pacientes.buscar.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rut" class="form-label fw-semibold">RUT del paciente</label>
                                <input type="text" class="form-control rounded-3" name="rut" id="rut" placeholder="Ej: 12.345.678-9" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-gradient px-4 py-2 fw-semibold">
                                    <i class="bi bi-search me-1"></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
