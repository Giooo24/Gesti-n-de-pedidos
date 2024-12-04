<?php
if (empty($_SESSION['active'])) {
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurante Gestión</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Estilo del Tema -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Barra de Navegación -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Enlaces de la izquierda -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Enlaces de la derecha -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Contenedor de la Barra Lateral -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Logo de la Marca -->
            <a href="dashboard.php" class="brand-link">
                <img src="../assets/img/logo.png" alt="Logo Restaurante" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Restaurante Gestión</span>
            </a>

            <!-- Barra Lateral -->
            <div class="sidebar">
                <!-- Panel del Usuario -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle fa-2x text-info"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
                    </div>
                </div>

                <!-- Menú de la Barra Lateral -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Panel de Control
                                </p>
                            </a>
                        </li>

                        <!-- Ventas -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-pizza-slice"></i>
                                <p>
                                    Ventas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
                                    echo '<li class="nav-item">
                                        <a href="index.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva venta</p>
                                        </a>
                                    </li>';
                                } if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                    echo '<li class="nav-item">
                                        <a href="lista_ventas.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Historial de Ventas</p>
                                        </a>
                                    </li>';
                                } ?>
                            </ul>
                        </li>

                        <!-- Gestión de Platos -->
                        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                            echo '<li class="nav-item">
                                <a href="platos.php" class="nav-link">
                                    <i class="nav-icon fas fa-coffee"></i>
                                    <p>
                                        Platos
                                    </p>
                                </a>
                            </li>';
                        } if ($_SESSION['rol'] == 1) {
                            echo '<li class="nav-item">
                                <a href="salas.php" class="nav-link">
                                    <i class="nav-icon fas fa-door-open"></i>
                                    <p>
                                        Salas
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Configuración
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="usuarios.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="config.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Configuración</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>';
                        } ?>

                        <!-- Cerrar sesión -->
                        <li class="nav-item">
                            <a href="salir.php" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Salir
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <!-- Contenido Principal -->
            <div class="content">
                <div class="container-fluid py-2">
