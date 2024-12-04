<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert = "";
        $id = $_POST['id'];
        $plato = $_POST['plato'];
        $precio = $_POST['precio'];
        $foto_actual = $_POST['foto_actual'];
        $foto = $_FILES['foto'];
        $fecha = date('YmdHis');
        if (empty($plato) || empty($precio) || $precio < 0) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todos los campos son obligatorios.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $nombre = null;
            if (!empty($foto['name'])) {
                $nombre = '../assets/img/platos/' . $fecha . '.jpg';
            } else if (!empty($foto_actual) && empty($foto['name'])) {
                $nombre = $foto_actual;
            }

            if (empty($id)) {
                $query = mysqli_query($conexion, "SELECT * FROM platos WHERE nombre = '$plato' AND estado = 1");
                $result = mysqli_fetch_array($query);
                if ($result > 0) {
                    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                El plato ya existe.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO platos (nombre,precio,imagen) VALUES ('$plato', '$precio', '$nombre')");
                    if ($query_insert) {
                        if (!empty($foto['name'])) {
                            move_uploaded_file($foto['tmp_name'], $nombre);
                        }
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Plato registrado exitosamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                    } else {
                        $alert = '<div class="alert alert-danger" role="alert">
                                    Error al registrar el plato.
                                </div>';
                    }
                }
            } else {
                $query_update = mysqli_query($conexion, "UPDATE platos SET nombre = '$plato', precio=$precio, imagen='$nombre' WHERE id = $id");
                if ($query_update) {
                    if (!empty($foto['name'])) {
                        move_uploaded_file($foto['tmp_name'], $nombre);
                    }
                    $alert = '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                Plato modificado exitosamente.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                } else {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Error al modificar el plato.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                }
            }
        }
    }
    include_once "includes/header.php";
?>
<div class="card shadow-lg">
    <div class="card-body">
        <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="plato" class="font-weight-bold text-dark">Nombre del plato</label>
                    <input type="text" name="plato" id="plato" class="form-control" placeholder="Ingrese nombre del plato">
                </div>
                <div class="form-group col-md-2">
                    <label for="precio" class="font-weight-bold text-dark">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" placeholder="Ingrese precio">
                </div>
                <div class="form-group col-md-3">
                    <label for="foto" class="font-weight-bold text-dark">Foto (512x512)</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label for="btnAccion" class="font-weight-bold text-dark">Acciones</label><br>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="button" class="btn btn-success" onclick="limpiar()">Nuevo</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
<?php } else { header('Location: permisos.php'); } ?>
