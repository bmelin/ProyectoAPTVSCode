@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg">
        <div class="card-header text-center bg-primary text-white">
          <h4>Inicio de Sesión</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input type="email" name="correo" id="correo" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
          </form>
          @if($errors->any())
            <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection