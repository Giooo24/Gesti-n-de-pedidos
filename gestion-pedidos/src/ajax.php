<?php
require_once "../conexion.php";
session_start();

// Obtener detalles de los productos en el pedido temporal
if (isset($_GET['detalle'])) {
    $userId = $_SESSION['idUser'];
    $pedidoDetalles = array();
    $query = mysqli_query($conexion, "SELECT d.*, p.nombre, p.precio, p.imagen 
                                      FROM temp_pedidos d 
                                      INNER JOIN platos p ON d.id_producto = p.id 
                                      WHERE d.id_usuario = $userId");
    while ($row = mysqli_fetch_assoc($query)) {
        $detalle['id'] = $row['id'];
        $detalle['nombre'] = $row['nombre'];
        $detalle['cantidad'] = $row['cantidad'];
        $detalle['precio'] = $row['precio'];
        $detalle['imagen'] = ($row['imagen'] == null) ? '../assets/img/default.png' : $row['imagen'];
        $detalle['total'] = $detalle['precio'] * $detalle['cantidad'];
        array_push($pedidoDetalles, $detalle);
    }
    echo json_encode($pedidoDetalles);
    die();
}

// Eliminar detalle de pedido temporal
else if (isset($_GET['delete_detalle'])) {
    $detalleId = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM temp_pedidos WHERE id = $detalleId");
    echo $query ? "ok" : "Error";
    die();
}

// Actualizar cantidad de un producto en el pedido temporal
else if (isset($_GET['detalle_cantidad'])) {
    $detalleId = $_GET['id'];
    $cantidad = $_GET['cantidad'];
    $query = mysqli_query($conexion, "UPDATE temp_pedidos SET cantidad = $cantidad WHERE id = $detalleId");
    echo $query ? "ok" : "Error";
    die();
}

// Procesar un pedido y agregarlo a la tabla de pedidos
else if (isset($_GET['procesarPedido'])) {
    $salaId = $_GET['id_sala'];
    $userId = $_SESSION['idUser'];
    $mesa = $_GET['mesa'];
    $observacion = $_GET['observacion'];
    $consulta = mysqli_query($conexion, "SELECT d.*, p.nombre 
                                        FROM temp_pedidos d 
                                        INNER JOIN platos p ON d.id_producto = p.id 
                                        WHERE d.id_usuario = $userId");
    $total = 0;
    while ($row = mysqli_fetch_assoc($consulta)) {
        $total += $row['cantidad'] * $row['precio'];
    }
    $insertarPedido = mysqli_query($conexion, "INSERT INTO pedidos (id_sala, num_mesa, total, observacion, id_usuario) 
                                               VALUES ($salaId, $mesa, '$total', '$observacion', $userId)");
    $pedidoId = mysqli_insert_id($conexion);
    if ($insertarPedido) {
        $consultaDetalle = mysqli_query($conexion, "SELECT d.*, p.nombre 
                                                    FROM temp_pedidos d 
                                                    INNER JOIN platos p ON d.id_producto = p.id 
                                                    WHERE d.id_usuario = $userId");
        while ($dato = mysqli_fetch_assoc($consultaDetalle)) {
            $nombre = $dato['nombre'];
            $cantidad = $dato['cantidad'];
            $precio = $dato['precio'];
            mysqli_query($conexion, "INSERT INTO detalle_pedidos (nombre, precio, cantidad, id_pedido) 
                                     VALUES ('$nombre', '$precio', $cantidad, $pedidoId)");
        }
        mysqli_query($conexion, "DELETE FROM temp_pedidos WHERE id_usuario = $userId");
        $sala = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $salaId");
        $resultSala = mysqli_fetch_assoc($sala);
        $msg = array('mensaje' => $resultSala['mesas']);
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
}

// Editar usuario
else if (isset($_GET['editarUsuario'])) {
    $usuarioId = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $usuarioId");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
}

// Editar producto
else if (isset($_GET['editarProducto'])) {
    $productoId = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM platos WHERE id = $productoId");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
}

// Finalizar pedido
else if (isset($_GET['finalizarPedido'])) {
    $salaId = $_GET['id_sala'];
    $userId = $_SESSION['idUser'];
    $mesa = $_GET['mesa'];
    $query = mysqli_query($conexion, "UPDATE pedidos SET estado='FINALIZADO' 
                                      WHERE id_sala = $salaId 
                                      AND num_mesa = $mesa 
                                      AND estado = 'PENDIENTE' 
                                      AND id_usuario = $userId");
    if ($query) {
        $sala = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $salaId");
        $resultSala = mysqli_fetch_assoc($sala);
        $msg = array('mensaje' => $resultSala['mesas']);
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
}

// Registrar detalle en el pedido temporal
if (isset($_POST['regDetalle'])) {
    $productoId = $_POST['id'];
    $userId = $_SESSION['idUser'];
    $consulta = mysqli_query($conexion, "SELECT * FROM temp_pedidos WHERE id_producto = $productoId AND id_usuario = $userId");
    $row = mysqli_fetch_assoc($consulta);
    if (empty($row)) {
        $producto = mysqli_query($conexion, "SELECT * FROM platos WHERE id = $productoId");
        $result = mysqli_fetch_assoc($producto);
        $precio = $result['precio'];
        $query = mysqli_query($conexion, "INSERT INTO temp_pedidos (cantidad, precio, id_producto, id_usuario) 
                                          VALUES (1, $precio, $productoId, $userId)");
    } else {
        $nuevaCantidad = $row['cantidad'] + 1;
        $query = mysqli_query($conexion, "UPDATE temp_pedidos SET cantidad = $nuevaCantidad 
                                          WHERE id_producto = $productoId AND id_usuario = $userId");
    }
    echo $query ? "registrado" : "Error al ingresar";
    die();
}
?>
