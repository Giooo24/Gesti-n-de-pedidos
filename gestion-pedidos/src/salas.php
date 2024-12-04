<?php
// Inicia la sesión para validar roles
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    // Validar campos obligatorios
    if (empty($_POST['nombre']) || empty($_POST['mesas'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todos los campos son obligatorios
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $mesas = $_POST['mesas'];

        if (empty($id)) {
            // Validar si ya existe la sala
            $query = mysqli_query($conexion, "SELECT * FROM salas WHERE nombre = '$nombre' AND estado = 1");
            if (mysqli_num_rows($query) > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            La sala ya existe
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
            } else {
                // Insertar nueva sala
                $query_insert = mysqli_query($conexion, "INSERT INTO salas (nombre, mesas) VALUES ('$nombre', '$mesas')");
                $alert = $query_insert
                    ? '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Sala registrada con éxito
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'
                    : '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al registrar la sala
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                      </div>';
            }
        } else {
            // Actualizar sala existente
            $sql_update = mysqli_query($conexion, "UPDATE salas SET nombre = '$nombre', mesas = '$mesas' WHERE id = $id");
            $alert = $sql_update
                ? '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Sala modificada con éxito
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                  </div>'
                : '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al modificar la sala
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                      </button>
                  </div>';
        }
    }
    mysqli_close($conexion);
}
include_once "includes/header.php";
?>

<div class="card">
    <div class="card-body">
        <div class="card">
            <div class="card-body">
                <!-- Mostrar alertas -->
                <?php echo isset($alert) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="mesas" class="text-dark font-weight-bold">Mesas</label>
                                <input type="number" placeholder="Mesas" name="mesas" id="mesas" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <label for="">Acciones</label> <br>
                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de salas -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tbl">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Mesas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conexion, "SELECT * FROM salas WHERE estado = 1");
                            if (mysqli_num_rows($query) > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['id']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td><?php echo $data['mesas']; ?></td>
                                        <td>
                                            <a href="#" onclick="editarCliente(<?php echo $data['id']; ?>)" class="btn btn-primary">
                                                <i class='fas fa-edit'></i>
                                            </a>
                                            <form action="eliminar.php?id=<?php echo $data['id']; ?>&accion=salas" method="post" class="confirmar d-inline">
                                                <button class="btn btn-danger" type="submit">
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
