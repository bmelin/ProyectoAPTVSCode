<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesión</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
  <!-- Título -->
  <h1 class="app-title">🩺 Detección Temprana de Cáncer de Mamas</h1>

  <!-- Tarjeta de Login -->
  <div class="card login-card border-0">
    <div class="card-body">
      <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Login Icon" class="login-icon mb-3">
        <h4 class="fw-bold text-primary">Inicio de Sesión</h4>
        <p class="text-muted mb-0">Ingresa tus credenciales para continuar</p>
      </div>

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <div class="input-group">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope"></i></span>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@correo.com" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="contrasena" class="form-label">Contraseña</label>
          <div class="input-group">
            <span class="input-group-text bg-primary text-white"><i class="bi bi-lock"></i></span>
            <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="••••••••" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3 shadow-sm">Iniciar Sesión</button>
      </form>

      @if($errors->any())
        <div class="alert alert-danger mt-3 text-center">
          {{ $errors->first() }}
        </div>
      @endif
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
