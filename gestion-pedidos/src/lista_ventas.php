<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    require_once "../conexion.php";
    $id_user = $_SESSION['idUser'];
    $query = mysqli_query($conexion, "SELECT p.*, s.nombre AS sala, u.nombre FROM pedidos p INNER JOIN salas s ON p.id_sala = s.id INNER JOIN usuarios u ON p.id_usuario = u.id");
    include_once "includes/header.php";
?>
    <div class="card">
        <div class="card-header text-center">
            <h4>Historial de Pedidos</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Sala</th>
                            <th>Mesa</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($query)) {
                            if ($row['estado'] == 'PENDIENTE') {
                                $estado = '<span class="badge badge-warning">Pendiente</span>';
                            } else {
                                $estado = '<span class="badge badge-success">Completado</span>';
                            }
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['sala']; ?></td>
                                <td><?php echo $row['num_mesa']; ?></td>
                                <td><?php echo $row['fecha']; ?></td>
                                <td>$<?php echo number_format($row['total'], 2); ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td>
                                    <?php echo $estado; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
