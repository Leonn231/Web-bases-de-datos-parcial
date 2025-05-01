<?php
include('conexion.php');

$producto_id = (int)$_POST['producto_id']; 
$usuario_id = 1; 
$estado = in_array($_POST['accion'], ['like', 'dislike']) ? $_POST['accion'] : null; // Validar el estado

if (!$estado) {
    die("Acción inválida");
}

// numero de likes o de dislikes
$sql_insert = "INSERT INTO likes (producto_id, usuario_id, estado, fecha) 
               VALUES ($producto_id, $usuario_id, '$estado', NOW())";
if (!$conn->query($sql_insert)) {
    die("Error al registrar like/dislike: " . htmlspecialchars($conn->error));
}

header("Location: producto.php?id=" . $producto_id);
exit;
?>
