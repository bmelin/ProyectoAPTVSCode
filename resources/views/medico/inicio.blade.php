@extends('layouts.app')

@section('content')

<div class="container">
  <h3>Bienvenido, Dr. {{ session('usuario')->nombre }}</h3>
  <p>Aquí puedes registrar pacientes y generar predicciones.</p>
</div>

@endsection