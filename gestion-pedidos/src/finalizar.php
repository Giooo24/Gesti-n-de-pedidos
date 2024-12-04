<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
    $fecha = date('Y-m-d');
    $id_sala = $_GET['id_sala'];
    $mesa = $_GET['mesa'];
    include_once "includes/header.php";
?>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-utensils"></i> Detalle de Pedido
            </h3>
        </div>
        <div class="card-body">
            <input type="hidden" id="id_sala" value="<?php echo $_GET['id_sala']; ?>">
            <input type="hidden" id="mesa" value="<?php echo $_GET['mesa']; ?>">

            <div class="row">
                <?php
                include "../conexion.php";
                $query = mysqli_query($conexion, "SELECT * FROM pedidos WHERE id_sala = $id_sala AND num_mesa = $mesa AND estado = 'PENDIENTE'");
                $result = mysqli_fetch_assoc($query);
                if (!empty($result)) { ?>
                    <div class="col-md-12 text-center">
                        <div class="col-12">
                            <strong>Fecha:</strong> <?php echo $result['fecha']; ?>
                            <hr>
                            <strong>Mesa:</strong> <?php echo $_GET['mesa']; ?>
                        </div>

                        <div class="bg-light py-2 px-3 mt-4">
                            <h2 class="mb-0 text-success">
                                $<?php echo number_format($result['total'], 2); ?>
                            </h2>
                        </div>
                        <hr>
                        <h3 class="text-primary">Platos</h3>
                        <div class="row">
                            <?php 
                            $id_pedido = $result['id'];
                            $query1 = mysqli_query($conexion, "SELECT * FROM detalle_pedidos WHERE id_pedido = $id_pedido");
                            while ($data1 = mysqli_fetch_assoc($query1)) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-warning">
                                            <h5 class="card-title">Precio</h5>
                                            <p class="card-text"><?php echo $data1['precio']; ?></p>
                                        </div>
                                        <div class="card-body text-center">
                                            <img class="img-fluid img-thumbnail rounded-circle" src="../assets/img/mesa.jpg" alt="Imagen del Plato">
                                        </div>
                                        <div class="card-footer">
                                            <p class="card-text"><?php echo $data1['nombre']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="mt-4">
                            <a class="btn btn-outline-success btn-block finalizarPedido" href="#">
                                <i class="fas fa-check-circle mr-2"></i> Finalizar Pedido
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
