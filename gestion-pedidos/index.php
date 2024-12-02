<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['correo']) || empty($_POST['pass'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Por favor, ingrese correo y contraseña.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['pass']));
            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$user' AND pass = '$pass'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['rol'] = $dato['rol'];
                header('Location: src/dashboard.php');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Usuario o contraseña incorrectos.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio de Sesión</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f4f6f9;
    }
    .login-box {
      margin-top: 50px;
    }
    .login-logo {
      font-weight: bold;
      color: #007bff;
    }
    .login-card-body {
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    .alert {
      margin-bottom: 20px;
    }
    .input-group-text {
      background-color: #f4f6f9;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Inicio de Sesión</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para continuar</p>

      <form action="" method="post" autocomplete="off">
        <?php echo (isset($alert)) ? $alert : '' ; ?>  
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" placeholder="Correo electrónico">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pass" placeholder="Contraseña">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
