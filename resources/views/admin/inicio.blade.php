@extends('layouts.app')

@section('content')

<div class="container">
  <h3>Bienvenido, Administrador {{ session('usuario')->nombre }}</h3>
  <p>Aquí puedes gestionar cuentas de médicos.</p>
</div>

<a href="{{ route('usuarios.crear') }}" class="btn btn-success">Crear Nuevo Usuario</a>

@endsection