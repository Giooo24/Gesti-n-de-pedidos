<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
    $id = $_GET['id_sala'];
    $mesas = $_GET['mesas'];
    include_once "includes/header.php";
?>
    <div class="card">
        <div class="card-header text-center">
            Gestión de Mesas
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                include "../conexion.php";
                $query = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $id");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    $data = mysqli_fetch_assoc($query);
                    if ($data['mesas'] == $mesas) {
                        $item = 1;
                        for ($i = 0; $i < $mesas; $i++) {
                            $consulta = mysqli_query($conexion, "SELECT * FROM pedidos WHERE id_sala = $id AND num_mesa = $item AND estado = 'PENDIENTE'");
                            $resultPedido = mysqli_fetch_assoc($consulta);
                ?>
                            <div class="col-md-3 mb-4">
                                <div class="card card-widget widget-user">
                                    <!-- Background color for the header -->
                                    <div class="widget-user-header bg-<?php echo empty($resultPedido) ? 'primary' : 'warning'; ?>">
                                        <h3 class="widget-user-username">Mesa <?php echo $item; ?></h3>
                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../assets/img/mesa.jpg" alt="Mesa Image">
                                    </div>
                                    <div class="card-footer">
                                        <div class="description-block">
                                            <?php if (empty($resultPedido)) {
                                                echo '<a class="btn btn-info btn-block" href="pedido.php?id_sala=' . $id . '&mesa=' . $item . '">Atender Mesa</a>';
                                            } else {
                                                echo '<a class="btn btn-success btn-block" href="finalizar.php?id_sala=' . $id . '&mesa=' . $item . '">Finalizar Pedido</a>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <?php 
                            $item++;
                        }
                    }
                } ?>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
