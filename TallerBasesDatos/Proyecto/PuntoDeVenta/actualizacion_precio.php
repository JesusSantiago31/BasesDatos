<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $nuevo_precio = $_POST['precio'];

    // Validar que el precio no sea negativo
    if ($nuevo_precio < 0) {
        header('Location: cambio_precio.php?error=El precio no puede ser negativo.');
        exit();
    }

    try {
        // Llamada al procedimiento almacenado para actualizar el precio
        $stmt = $pdo->prepare("CALL ActualizarPrecioProducto(?, ?)");
        $stmt->execute([$id_producto, $nuevo_precio]);

        // Redirigir con mensaje de éxito
        header('Location: cambio_precio.php?success=Precio actualizado exitosamente.');
    } catch (PDOException $e) {
        // Redirigir con mensaje de error en caso de fallo en la consulta
        header('Location: cambio_precio.php?error=' . $e->getMessage());
    }
}
