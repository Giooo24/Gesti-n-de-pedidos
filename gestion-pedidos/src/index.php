<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
    include_once "includes/header.php";
?>
    <div class="card">
        <div class="card-header text-center">
            <h4>Salas Disponibles</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                include "../conexion.php";
                $query = mysqli_query($conexion, "SELECT * FROM salas WHERE estado = 1");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-lg">
                                <div class="card-body text-center">
                                    <img src="../assets/img/salas.jpg" class="card-img-top mb-3" alt="Sala Image">
                                    <h6 class="my-3">
                                        <span class="badge badge-info"><?php echo $data['nombre']; ?></span>
                                    </h6>
                                    <a class="btn btn-outline-primary btn-block" href="mesas.php?id_sala=<?php echo $data['id']; ?>&mesas=<?php echo $data['mesas']; ?>">
                                        <i class="far fa-eye mr-2"></i>
                                        Ver Mesas
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
