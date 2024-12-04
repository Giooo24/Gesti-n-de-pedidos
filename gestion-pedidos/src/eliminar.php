<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

require("../conexion.php");

if (empty($_SESSION['idUser'])) {
    header('Location: ../');
    exit;
}

if (!empty($_GET['id']) && !empty($_GET['accion'])) {
    $id = $_GET['id'];
    $table = $_GET['accion'];
    $id_user = $_SESSION['idUser'];

    // Realizar la actualización del estado
    $query_delete = mysqli_query($conexion, "UPDATE $table SET estado = 0 WHERE id = $id");

    if ($query_delete) {
        // Cerrar la conexión y redirigir
        mysqli_close($conexion);
        header("Location: " . $table . '.php');
    } else {
        echo "Error al actualizar el estado del registro.";
    }
}
?>
